{{--
    Partial reutilizado por boletas/create, stickers/create y actas/create.
    Soporta búsqueda directa en SAP PM vía Web Service SOAP y búsqueda local en MySQL.
--}}
<div class="form-card" style="margin-top: 0;">
    <div class="form-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <span class="form-title">Paso 1: Seleccione o Consulte el Vehículo</span>
        <div style="display: flex; gap: 8px;">
            <button type="button" id="tab-sap-btn" onclick="cambiarModoBusqueda('sap')" class="btn-primary" style="padding: 6px 14px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 1-9 9m9-9a9 9 0 0 0-9-9m9 9H3m9 9a9 9 0 0 1-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                Consulta API SAP
            </button>
            <button type="button" id="tab-local-btn" onclick="cambiarModoBusqueda('local')" class="btn-secondary" style="padding: 6px 14px; font-size: 13px;">
                Búsqueda Local
            </button>
        </div>
    </div>

    <div style="padding: 24px;">

        {{-- SECCIÓN 1: CONSULTA DIRECTA A SAP --}}
        <div id="panel-busqueda-sap">
            <div style="background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%); border: 1.5px solid #bfdbfe; border-radius: 10px; padding: 18px 20px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="background: #1e3a8a; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; letter-spacing: 0.5px;">SAP PM</span>
                        <strong style="color: #1e3a8a; font-size: 14px;">Consulta en Vivo al Maestro de Vehículos</strong>
                    </div>
                    <span style="font-size: 12px; color: #059669; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 5px; background: #10b981;"></span>
                        Web Service Activo (Mandante 300)
                    </span>
                </div>
                <p style="font-size: 13px; color: #334155; margin-bottom: 14px;">
                    Ingrese el <strong>Número de Equipo SAP</strong> (ej. <code>10004466</code> o <code>10003522</code>). El sistema consultará automáticamente el servicio web y traerá los datos del vehículo para la boleta.
                </p>

                <form id="form-consulta-sap" onsubmit="ejecutarConsultaSap(event)" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <input type="text" id="sap-input-equipo" name="numero_equipo" class="form-control" style="flex: 1; min-width: 240px; font-weight: 600;" placeholder="Ej: 10004466" required autofocus>
                    <button type="submit" id="btn-sap-submit" class="btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px;">
                        <svg id="sap-spinner" style="display: none; animation: spin 1s linear infinite;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        <span>Consultar en SAP</span>
                    </button>
                </form>
            </div>

            {{-- Área de Resultado SAP --}}
            <div id="sap-mensaje-error" style="display: none; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; color: #991b1b; font-size: 13.5px;"></div>

            <div id="sap-card-resultado" style="display: none; background: #ffffff; border: 2px solid #3b82f6; border-radius: 12px; padding: 22px; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.12); margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
                    <div>
                        <span style="background: #dbeafe; color: #1e40af; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                            Datos Oficiales SAP PM
                        </span>
                        <h3 id="res-sap-titulo" style="font-size: 17px; font-weight: 700; color: #0f172a; margin-top: 6px;"></h3>
                        <p id="res-sap-dependencia" style="font-size: 13px; color: #64748b; margin-top: 2px;"></p>
                    </div>
                    <span id="res-sap-estado" style="background: #f1f5f9; color: #334155; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px;"></span>
                </div>

                {{-- Grid de Campos Extraídos de SAP --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; background: #f8fafc; border-radius: 8px; padding: 14px; margin-bottom: 20px;">
                    <div>
                        <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600;">No. Equipo SAP</span>
                        <strong id="res-sap-equipo" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                    <div>
                        <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600;">Marca</span>
                        <strong id="res-sap-marca" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                    <div>
                        <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600;">Modelo</span>
                        <strong id="res-sap-modelo" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                    <div>
                        <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600;">Tipo / Línea</span>
                        <strong id="res-sap-tipo" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                    <div>
                        <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600;">Año</span>
                        <strong id="res-sap-anio" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                    <div>
                        <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600;">Naturaleza / Origen</span>
                        <strong id="res-sap-naturaleza" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                </div>

                {{-- Formulario de Sincronización / Confirmación de Placa y Chasis --}}
                <form id="form-sincronizar-sap" method="POST" action="{{ route('sap.sincronizar') }}">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ $rutaCreate }}">
                    <input type="hidden" id="sync-numero-equipo" name="numero_equipo">
                    <input type="hidden" id="sync-sap-codigo" name="sap_codigo">
                    <input type="hidden" id="sync-marca" name="marca">
                    <input type="hidden" id="sync-modelo" name="modelo">
                    <input type="hidden" id="sync-linea" name="linea">
                    <input type="hidden" id="sync-anio" name="anio">
                    <input type="hidden" id="sync-naturaleza" name="naturaleza_origen">
                    <input type="hidden" id="sync-dependencia" name="dependencia">
                    <input type="hidden" id="sync-denominacion" name="denominacion">
                    <input type="hidden" id="sync-estado-sap" name="estado_sap">
                    <input type="hidden" id="sync-tipo-equipo" name="tipo_equipo">
                    <input type="hidden" id="sync-centro-costo" name="centro_costo">
                    <input type="hidden" id="sync-centro" name="centro">
                    <input type="hidden" id="sync-kilometraje" name="kilometraje">

                    <div id="sap-campos-complementarios" style="border-top: 1px dashed #cbd5e1; padding-top: 16px; margin-top: 16px;">
                        <p style="font-size: 13px; color: #1e3a8a; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            Datos de identificación física del vehículo (opcionales; si no se ingresan, se dejan en blanco):
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                            <div>
                                <label class="form-label" for="sync-placa" style="font-size: 12.5px;">Placa / Registro</label>
                                <input type="text" id="sync-placa" name="placa" class="form-control" placeholder="Ej: HAA-1234">
                            </div>
                            <div>
                                <label class="form-label" for="sync-chasis" style="font-size: 12.5px;">Chasis / VIN</label>
                                <input type="text" id="sync-chasis" name="chasis" class="form-control" placeholder="Ej: 1HZ0406436">
                            </div>
                            <div>
                                <label class="form-label" for="sync-motor" style="font-size: 12.5px;">Motor</label>
                                <input type="text" id="sync-motor" name="motor" class="form-control" placeholder="Número de motor">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 20px; gap: 10px;">
                        <button type="submit" class="btn-primary" style="padding: 10px 24px; font-weight: 600; font-size: 14px; background: #059669; border-color: #047857;">
                            <span>✓ Continuar con este Vehículo →</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SECCIÓN 2: BÚSQUEDA LOCAL EN MYSQL --}}
        <div id="panel-busqueda-local" style="display: none;">
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 12px;">
                Busque en los vehículos registrados previamente en la base de datos local por placa, chasis o marca:
            </p>
            <form method="GET" action="{{ route($rutaCreate) }}" style="display: flex; gap: 12px;">
                <input type="text" name="q" value="{{ $query ?? '' }}" class="form-control" placeholder="Buscar por placa o chasis...">
                <button type="submit" class="btn-primary">Buscar</button>
            </form>

            @if(($query ?? '') !== '')
                <div style="margin-top: 20px;">
                    @forelse($resultados as $v)
                        <div style="display:flex; align-items:center; justify-content:space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 10px; background: #fff;">
                            <div>
                                <strong>{{ $v->placa }}</strong> — {{ $v->marca }} {{ $v->modelo }} ({{ $v->anio ?? 's/f' }})
                                <div style="font-size: 12px; color: var(--text-muted);">
                                    Chasis: {{ $v->chasis }}
                                    @if($v->numero_equipo)
                                        · No. Equipo: <strong>{{ $v->numero_equipo }}</strong>
                                    @endif
                                    @if($v->naturaleza_origen)
                                        · Origen: {{ $v->naturaleza_origen }}
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route($rutaCreate, ['vehicle_id' => $v->id]) }}" class="btn-secondary" style="padding: 8px 16px; font-size: 13px; font-weight: 600;">
                                Seleccionar ➔
                            </a>
                        </div>
                    @empty
                        <div style="padding: 16px; border: 1px dashed var(--border-color); border-radius: 8px; text-align: center; color: var(--text-muted); font-size: 13.5px; margin-top: 12px;">
                            No se encontraron vehículos en el registro local con ese criterio. Puede consultarlo directamente en SAP en la pestaña superior.
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

    </div>
</div>

<style>
    @keyframes spin { 100% { transform: rotate(360deg); } }
    @media (max-width: 600px) {
        #form-consulta-sap {
            flex-direction: column;
            align-items: stretch;
        }
        #sap-input-equipo {
            min-width: 0 !important;
            width: 100%;
        }
        #btn-sap-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
function cambiarModoBusqueda(modo) {
    const panelSap = document.getElementById('panel-busqueda-sap');
    const panelLocal = document.getElementById('panel-busqueda-local');
    const btnSap = document.getElementById('tab-sap-btn');
    const btnLocal = document.getElementById('tab-local-btn');

    if (modo === 'sap') {
        panelSap.style.display = 'block';
        panelLocal.style.display = 'none';
        btnSap.className = 'btn-primary';
        btnLocal.className = 'btn-secondary';
        document.getElementById('sap-input-equipo').focus();
    } else {
        panelSap.style.display = 'none';
        panelLocal.style.display = 'block';
        btnSap.className = 'btn-secondary';
        btnLocal.className = 'btn-primary';
    }
}

// Si hay una búsqueda local activa en URL (?q=...), mostrar panel local
@if(($query ?? '') !== '')
    document.addEventListener('DOMContentLoaded', function() {
        cambiarModoBusqueda('local');
    });
@endif

async function ejecutarConsultaSap(e) {
    e.preventDefault();
    const input = document.getElementById('sap-input-equipo');
    const equipo = input.value.trim();
    if (!equipo) return;

    const btn = document.getElementById('btn-sap-submit');
    const spinner = document.getElementById('sap-spinner');
    const errorBox = document.getElementById('sap-mensaje-error');
    const cardResultado = document.getElementById('sap-card-resultado');

    btn.disabled = true;
    spinner.style.display = 'inline-block';
    errorBox.style.display = 'none';
    cardResultado.style.display = 'none';

    try {
        const response = await fetch('{{ route("sap.consultar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ numero_equipo: equipo })
        });

        const res = await response.json();

        if (!response.ok || !res.success) {
            throw new Error(res.message || 'No fue posible consultar el vehículo en SAP.');
        }

        const data = res.data;
        const local = res.local_vehicle;

        // Llenar tarjeta de resultado
        document.getElementById('res-sap-titulo').textContent = `${data.marca} ${data.modelo} (${data.anio || 's/f'})`;
        document.getElementById('res-sap-dependencia').textContent = data.dependencia ? `Asignado a: ${data.dependencia}` : (data.denominacion || '');
        document.getElementById('res-sap-estado').textContent = data.estado_sap || 'Registrado en SAP';
        document.getElementById('res-sap-equipo').textContent = data.numero_equipo;
        document.getElementById('res-sap-marca').textContent = data.marca || '—';
        document.getElementById('res-sap-modelo').textContent = data.modelo || '—';
        document.getElementById('res-sap-tipo').textContent = data.linea || '—';
        document.getElementById('res-sap-anio').textContent = data.anio || '—';
        document.getElementById('res-sap-naturaleza').textContent = data.naturaleza_origen || '—';

        // Llenar campos ocultos de sincronización
        document.getElementById('sync-numero-equipo').value = data.numero_equipo;
        document.getElementById('sync-sap-codigo').value = data.sap_codigo;
        document.getElementById('sync-marca').value = data.marca;
        document.getElementById('sync-modelo').value = data.modelo;
        document.getElementById('sync-linea').value = data.linea || '';
        document.getElementById('sync-anio').value = data.anio || '';
        document.getElementById('sync-naturaleza').value = data.naturaleza_origen || '';
        document.getElementById('sync-dependencia').value = data.dependencia || '';
        document.getElementById('sync-denominacion').value = data.denominacion || '';
        document.getElementById('sync-estado-sap').value = data.estado_sap || '';
        document.getElementById('sync-tipo-equipo').value = data.tipo_equipo || '';
        document.getElementById('sync-centro-costo').value = data.centro_costo || '';
        document.getElementById('sync-centro').value = data.centro || '';
        document.getElementById('sync-kilometraje').value = data.kilometraje || '';

        // Campos complementarios (placa / chasis / motor)
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.value = val || '';
        };
        setVal('sync-placa', local ? local.placa : '');
        setVal('sync-chasis', local ? local.chasis : '');
        setVal('sync-motor', local ? local.motor : '');

        cardResultado.style.display = 'block';
        cardResultado.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

    } catch (err) {
        errorBox.textContent = err.message;
        errorBox.style.display = 'block';
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}
</script>
