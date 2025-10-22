<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="paciente_id">Paciente *</label>
            <select name="paciente_id" id="paciente_id" class="form-control @error('paciente_id') is-invalid @enderror" required>
                <option value="">Seleccione un paciente</option>
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" 
                        {{ (old('paciente_id', $seguimiento->paciente_id ?? '') == $paciente->id) ? 'selected' : '' }}>
                        {{ $paciente->nombre_completo }} - CI: {{ $paciente->CI }}
                    </option>
                @endforeach
            </select>
            @error('paciente_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="fecha_seguimiento">Fecha de Seguimiento *</label>
            <input type="date" name="fecha_seguimiento" id="fecha_seguimiento" 
                   class="form-control @error('fecha_seguimiento') is-invalid @enderror"
                   value="{{ old('fecha_seguimiento', $seguimiento->fecha_seguimiento ?? date('Y-m-d')) }}" 
                   max="{{ date('Y-m-d') }}" required>
            @error('fecha_seguimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="peso">Peso (kg) *</label>
            <input type="number" name="peso" id="peso" step="0.01" min="0.1" max="300"
                   class="form-control @error('peso') is-invalid @enderror"
                   value="{{ old('peso', $seguimiento->peso ?? '') }}" 
                   placeholder="Ej: 65.5" required>
            @error('peso')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="talla">Talla (cm) *</label>
            <input type="number" name="talla" id="talla" step="0.01" min="30" max="250"
                   class="form-control @error('talla') is-invalid @enderror"
                   value="{{ old('talla', $seguimiento->talla ?? '') }}" 
                   placeholder="Ej: 170.5" required>
            @error('talla')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">Estado *</label>
            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                <option value="activo" {{ (old('estado', $seguimiento->estado ?? '') == 'activo') ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ (old('estado', $seguimiento->estado ?? '') == 'inactivo') ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    @if(isset($seguimiento) && $seguimiento->imc)
    <div class="col-md-6">
        <div class="form-group">
            <label>IMC Calculado</label>
            <div class="alert alert-info p-2">
                <strong>{{ $seguimiento->imc }}</strong> - {{ $seguimiento->clasificacion_imc }}
            </div>
        </div>
    </div>
    @endif
</div>

<div class="form-group mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($seguimiento) ? 'Actualizar' : 'Crear' }} Seguimiento
    </button>
    <a href="{{ route('seguimientos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Cancelar
    </a>
</div>