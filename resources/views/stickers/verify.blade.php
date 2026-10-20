<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Verificación de sticker</title><style>body{font-family:Arial,sans-serif;background:#f8fafc;color:#0f172a;padding:32px}.card{max-width:560px;margin:auto;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:28px}.ok{color:#047857}.bad{color:#b91c1c}dt{font-weight:700;margin-top:14px}dd{margin:4px 0}</style></head>
<body><main class="card"><h1>Verificación de sticker</h1><h2 class="{{ $sticker->estado === 'activo' ? 'ok' : 'bad' }}">{{ strtoupper($sticker->estado) }}</h2>
<dl><dt>Código</dt><dd>{{ $sticker->codigo }}</dd><dt>Placa</dt><dd>{{ $sticker->vehicle->placa }}</dd><dt>Marca y modelo</dt><dd>{{ $sticker->vehicle->marca }} {{ $sticker->vehicle->modelo }}</dd><dt>Emisión</dt><dd>{{ $sticker->fecha_emision->format('d/m/Y') }}</dd></dl>
<p>Esta consulta no expone datos personales del propietario.</p></main></body></html>
