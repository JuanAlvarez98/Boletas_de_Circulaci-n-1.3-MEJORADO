{{-- Partial de campos, usado por vehicles/create.blade.php y vehicles/edit.blade.php --}}

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0 20px;">

    <div class="form-group">
        <label for="placa" class="form-label">Placa *</label>
        <input type="text" id="placa" name="placa" value="{{ old('placa', $vehicle->placa ?? '') }}" class="form-control" placeholder="Ej. HAB-1234" required autofocus>
        @error('placa')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
       <label for="numero_equipo" class="form-label">  No. de equipo </label>
       <input type="text" id="numero_equipo" name="numero_equipo" value="{{ old('numero_equipo', $vehicle->numero_equipo ?? '') }}" class="form-control"  placeholder="Ej. 10006905">
       @error('numero_equipo')<div class="input-error">{{ $message }}</div> @enderror    
    </div>


    <div class="form-group">
        <label for="chasis" class="form-label">Chasis *</label>
        <input type="text" id="chasis" name="chasis" value="{{ old('chasis', $vehicle->chasis ?? '') }}" class="form-control" required>
        @error('chasis')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="motor" class="form-label">No. Motor</label>
        <input type="text" id="motor" name="motor" value="{{ old('motor', $vehicle->motor ?? '') }}" class="form-control">
        @error('motor')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="marca" class="form-label">Marca *</label>
        <input type="text" id="marca" name="marca" value="{{ old('marca', $vehicle->marca ?? '') }}" class="form-control" required>
        @error('marca')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="modelo" class="form-label">Modelo *</label>
        <input type="text" id="modelo" name="modelo" value="{{ old('modelo', $vehicle->modelo ?? '') }}" class="form-control" required>
        @error('modelo')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="linea" class="form-label">Línea / Tipo</label>
        <input type="text" id="linea" name="linea" value="{{ old('linea', $vehicle->linea ?? '') }}" class="form-control" placeholder="Sedán, pick-up, motocicleta...">
        @error('linea')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="anio" class="form-label">Año</label>
        <input type="number" id="anio" name="anio" value="{{ old('anio', $vehicle->anio ?? '') }}" class="form-control" min="1950" max="{{ date('Y') + 1 }}">
        @error('anio')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="color" class="form-label">Color</label>
        <input type="text" id="color" name="color" value="{{ old('color', $vehicle->color ?? '') }}" class="form-control">
        @error('color')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="naturaleza_origen" class="form-label">Naturaleza / Origen</label>
        <select id="naturaleza_origen" name="naturaleza_origen" class="form-control">
            <option value="">Seleccionar origen...</option>
            <option value="Rentado" @selected(old('naturaleza_origen', $vehicle->naturaleza_origen ?? '') === 'Rentado')>Rentado</option>
            <option value="Orgánico" @selected(old('naturaleza_origen', $vehicle->naturaleza_origen ?? '') === 'Orgánico')>Orgánico</option>
        </select>
        @error('naturaleza_origen')<div class="input-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="sap_codigo" class="form-label">Código SAP (si aplica)</label>
        <input type="text" id="sap_codigo" name="sap_codigo" value="{{ old('sap_codigo', $vehicle->sap_codigo ?? '') }}" class="form-control" placeholder="Se completará al integrar con SAP">
        @error('sap_codigo')<div class="input-error">{{ $message }}</div>@enderror
    </div>

</div>
