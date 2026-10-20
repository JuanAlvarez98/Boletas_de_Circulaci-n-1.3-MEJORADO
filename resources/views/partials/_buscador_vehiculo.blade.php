{{--
    Partial reutilizado por boletas/create, stickers/create y actas/create.
    Espera las variables: $resultados, $query y la ruta destino ($rutaCreate, con nombre de la ruta actual).
--}}
<div class="form-card" style="margin-top: 0;">
    <div class="form-header"><span class="form-title">Paso 1: Seleccione el Vehículo</span></div>

    <div style="padding: 24px;">
        <form method="GET" action="{{ route($rutaCreate) }}" style="display: flex; gap: 12px;">
            <input type="text" name="q" value="{{ $query ?? '' }}" class="form-control" placeholder="Buscar por placa o chasis..." autofocus>
            <button type="submit" class="btn-primary">Buscar</button>
        </form>

        @if(($query ?? '') !== '')
            <div style="margin-top: 20px;">
                @forelse($resultados as $v)
                    <div style="display:flex; align-items:center; justify-content:space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 10px;">
                        <div>
                            <strong>{{ $v->placa }}</strong> — {{ $v->marca }} {{ $v->modelo }}
                            <div style="font-size: 12px; color: var(--text-muted);">
                                Chasis: {{ $v->chasis }}
                                @if($v->numero_equipo)
                                    · No. Equipo: {{ $v->numero_equipo }}
                                @endif
                            </div>
                        </div>
                        <a href="{{ route($rutaCreate, ['vehicle_id' => $v->id]) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">Seleccionar</a>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-size: 13.5px; margin-top: 12px;">No se encontraron vehículos con ese criterio.</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
