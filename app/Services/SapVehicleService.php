<?php

namespace App\Services;

use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SapVehicleService
{
    protected string $url;
    protected string $client;
    protected string $user;
    protected string $password;
    protected int $timeout;

    public function __construct()
    {
        $this->url = (string) config('sap.url');
        $this->client = (string) config('sap.client', '300');
        $this->user = (string) config('sap.user', 'WASAPPM');
        $this->password = (string) config('sap.password', 'Temp2610');
        $this->timeout = (int) config('sap.timeout', 15);
    }

    /**
     * Resuelve la URL del endpoint SOAP de SAP.
     * Si se proporciona la URL de WSDL con '/bndg_url/', extrae automáticamente la URL de enlace directo.
     */
    public function getEndpointUrl(): string
    {
        $rawUrl = trim($this->url);

        if (str_contains($rawUrl, '/bndg_url/')) {
            $parsed = parse_url($rawUrl);
            $scheme = $parsed['scheme'] ?? 'http';
            $host = $parsed['host'] ?? 'ecc-db-qa.seguridad.gob.hn';
            $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
            $pos = strpos($rawUrl, '/bndg_url/');
            $bindingPath = substr($rawUrl, $pos + strlen('/bndg_url/'));
            $rawUrl = "{$scheme}://{$host}{$port}/" . ltrim($bindingPath, '/');
        }

        if (!str_contains($rawUrl, 'sap-client=')) {
            $separator = str_contains($rawUrl, '?') ? '&' : '?';
            $rawUrl .= "{$separator}sap-client={$this->client}";
        }

        return $rawUrl;
    }

    /**
     * Da formato al número de equipo para SAP (18 caracteres con ceros a la izquierda si es numérico).
     */
    public function formatVehicleId(string $id): string
    {
        $clean = trim($id);
        if (ctype_digit($clean) && strlen($clean) < 18) {
            return str_pad($clean, 18, '0', STR_PAD_LEFT);
        }
        return $clean;
    }

    /**
     * Limpia ceros a la izquierda para visualización amigable (ej. 000000000010001683 -> 10001683).
     */
    public function cleanVehicleId(string $id): string
    {
        $trimmed = ltrim(trim($id), '0');
        return $trimmed !== '' ? $trimmed : trim($id);
    }

    /**
     * Consulta el vehículo en SAP mediante el Web Service SOAP.
     * Retorna array asociativo con los campos mapeados o null si no existe.
     *
     * @throws Exception en caso de error de conexión o credenciales
     */
    public function consultar(string $codigoVehiculo): ?array
    {
        $formattedId = $this->formatVehicleId($codigoVehiculo);

        $soapEnvelope = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:sap-com:document:sap:rfc:functions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:Z_WSPM_ORDEN_COMBUSTIBLE>
         <L_VEHICULO>{$formattedId}</L_VEHICULO>
      </urn:Z_WSPM_ORDEN_COMBUSTIBLE>
   </soapenv:Body>
</soapenv:Envelope>
XML;

        $targetUrl = $this->getEndpointUrl();

        try {
            $response = Http::withBasicAuth($this->user, $this->password)
                ->withHeaders([
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'SOAPAction' => '""',
                ])
                ->timeout($this->timeout)
                ->withBody($soapEnvelope, 'text/xml')
                ->post($targetUrl);

            if ($response->status() === 401) {
                Log::error('SAP Web Service: 401 Unauthorized. Verifique usuario y contraseña en .env.');
                throw new Exception('Error de autenticación con SAP (401 Unauthorized). Verifique las credenciales.');
            }

            if (!$response->successful()) {
                Log::error('SAP Web Service error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new Exception("Error al consultar SAP (HTTP {$response->status()}).");
            }

            return $this->parseSoapResponse($response->body());
        } catch (Exception $e) {
            Log::error('Excepción al consultar vehículo en SAP: ' . $e->getMessage(), [
                'codigo' => $codigoVehiculo,
            ]);
            throw $e;
        }
    }

    /**
     * Parsea la respuesta XML de SAP y extrae los campos requeridos en la ficha.
     * Si algún campo solicitado no está presente en la respuesta de SAP, se deja en blanco (null).
     */
    protected function parseSoapResponse(string $xmlContent): ?array
    {
        // Registrar prefijos para evitar conflictos con namespaces SOAP
        $cleanXml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$3', $xmlContent);
        $xml = @simplexml_load_string($cleanXml);

        if ($xml === false) {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOWARNING | LIBXML_NOERROR);
            if ($xml === false) {
                return null;
            }
        }

        // Buscar el nodo L_DETALLE -> item
        $items = $xml->xpath('//L_DETALLE/item') ?: $xml->xpath('//*[local-name()="L_DETALLE"]/*[local-name()="item"]');

        if (empty($items)) {
            return null;
        }

        $item = $items[0];

        $equnr = trim((string) ($item->EQUNR ?? ''));
        if ($equnr === '') {
            return null;
        }

        // Kilometraje desde L_KILOMETRAJE
        $kmItems = $xml->xpath('//L_KILOMETRAJE/item') ?: $xml->xpath('//*[local-name()="L_KILOMETRAJE"]/*[local-name()="item"]');
        $kilometraje = null;
        if (!empty($kmItems) && !empty($kmItems[0]->RECDV)) {
            $rawKm = (float) $kmItems[0]->RECDV;
            $unidadKm = trim((string) ($kmItems[0]->RECDU ?? 'KM'));
            $kilometraje = number_format($rawKm, 0, '.', ',') . ($unidadKm !== '' ? ' ' . $unidadKm : ' KM');
        }

        $denominacion = trim((string) ($item->EQKTX ?? ''));

        // Solo los campos que solicita la ficha; si alguno no está en SAP, se deja en blanco (null)
        return [
            'numero_equipo' => $this->cleanVehicleId($equnr),
            'sap_codigo' => $equnr,
            'marca' => trim((string) ($item->HERST ?? '')) ?: null,
            'modelo' => trim((string) ($item->TYPBZ ?? $item->TYPB2 ?? '')) ?: null,
            'linea' => trim((string) ($item->EARTX ?? '')) ?: null, // Tipo / Línea (Camioneta, Microbus, etc.)
            'tipo_equipo' => trim((string) ($item->TYPTX ?? '')) ?: null, // Vehiculos terrestres, etc.
            'anio' => !empty($item->BAUJJ) ? (int) $item->BAUJJ : null,
            'naturaleza_origen' => trim((string) ($item->TYPE_TEXT ?? '')) ?: null, // Orgánicos, Rentado, etc.
            'dependencia' => trim((string) ($item->NAME1 ?? '')) ?: null, // Dirección / Dependencia policial
            'denominacion' => $denominacion ?: null,
            'estado_sap' => trim((string) ($item->USER_STATUS_DESC ?? '')) ?: null,
            'color' => trim((string) ($item->FARBE ?? $item->COLOR ?? '')) ?: null,
            'cilindraje' => trim((string) ($item->HUBRAUM ?? $item->CILINDRAJE ?? $item->DISPLACEMENT ?? '')) ?: null,
            'tipo_combustible' => trim((string) ($item->KRAFTSTOFF ?? $item->FUEL_TYPE ?? $item->COMBUSTIBLE ?? '')) ?: null,
            'tipo_abastecimiento' => trim((string) ($item->ABASTECIMIENTO ?? $item->TIPO_ABASTECIMIENTO ?? '')) ?: null,
            'nombre_rentadora' => trim((string) ($item->RENTADORA ?? $item->NOMBRE_RENTADORA ?? $item->LESSOR ?? '')) ?: null,
            'blindaje' => trim((string) ($item->BLINDAJE ?? $item->ARMOR ?? '')) ?: null,
            'activo_fijo' => trim((string) ($item->ANLNR ?? $item->ACTIVO_FIJO ?? $item->ASSET ?? '')) ?: null,
            // Campos que no vienen en el Web Service de SAP: se dejan en blanco
            'placa' => null,
            'chasis' => null,
            'motor' => null,
        ];
    }

    /**
     * Sincroniza o registra localmente el vehículo consultado desde SAP
     * para que pueda ser utilizado en la emisión de boletas, stickers y actas.
     * Los campos no provistos por SAP se dejan en blanco.
     */
    public function sincronizarLocalmente(array $sapData, array $complementos = []): Vehicle
    {
        $numeroEquipo = $sapData['numero_equipo'] ?? null;
        $sapCodigo = $sapData['sap_codigo'] ?? null;

        // Buscar si ya existe localmente por número de equipo o sap_codigo
        $vehicle = Vehicle::query()
            ->when($numeroEquipo, fn ($q) => $q->where('numero_equipo', $numeroEquipo))
            ->orWhere(fn ($q) => $q->when($sapCodigo, fn ($sq) => $sq->where('sap_codigo', $sapCodigo)))
            ->first();

        $datosActualizar = [
            'numero_equipo' => $numeroEquipo,
            'sap_codigo' => $sapCodigo,
            'marca' => $sapData['marca'] ?? ($vehicle->marca ?? null),
            'modelo' => $sapData['modelo'] ?? ($vehicle->modelo ?? null),
            'linea' => $sapData['linea'] ?? ($vehicle->linea ?? null),
            'tipo_equipo' => $sapData['tipo_equipo'] ?? ($vehicle->tipo_equipo ?? null),
            'anio' => $sapData['anio'] ?? ($vehicle->anio ?? null),
            'naturaleza_origen' => $sapData['naturaleza_origen'] ?? ($vehicle->naturaleza_origen ?? null),
            'dependencia' => $sapData['dependencia'] ?? ($vehicle->dependencia ?? null),
            'denominacion' => $sapData['denominacion'] ?? ($vehicle->denominacion ?? null),
            'estado_sap' => $sapData['estado_sap'] ?? ($vehicle->estado_sap ?? null),
            'centro_costo' => $sapData['centro_costo'] ?? ($vehicle->centro_costo ?? null),
            'centro' => $sapData['centro'] ?? ($vehicle->centro ?? null),
            'kilometraje' => $sapData['kilometraje'] ?? ($vehicle->kilometraje ?? null),
        ];

        // Campos complementarios: si no están provistos, se dejan en blanco (null)
        $datosActualizar['placa'] = !empty($complementos['placa']) ? trim($complementos['placa']) : ($vehicle->placa ?? $sapData['placa'] ?? null);
        $datosActualizar['chasis'] = !empty($complementos['chasis']) ? trim($complementos['chasis']) : ($vehicle->chasis ?? $sapData['chasis'] ?? null);
        $datosActualizar['motor'] = !empty($complementos['motor']) ? trim($complementos['motor']) : ($vehicle->motor ?? $sapData['motor'] ?? null);
        $datosActualizar['color'] = !empty($complementos['color']) ? trim($complementos['color']) : ($vehicle->color ?? $sapData['color'] ?? null);

        if ($vehicle) {
            $vehicle->update($datosActualizar);
            return $vehicle;
        }

        return Vehicle::create($datosActualizar);
    }
}
