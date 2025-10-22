<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Peso (kg)</th>
                <th>Talla (cm)</th>
                <th>IMC</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seguimientos as $seguimiento)
                <tr>
                    <td>
                        <strong>{{ $seguimiento->paciente->nombre_completo }}</strong>
                        <br><small class="text-muted">CI: {{ $seguimiento->paciente->CI }}</small>
                    </td>
                    <td>{{ $seguimiento->fecha_seguimiento->format('d/m/Y') }}</td>
                    <td>{{ $seguimiento->peso }}</td>
                    <td>{{ $seguimiento->talla }}</td>
                    <td>
                        @if($seguimiento->imc)
                            <span class="badge 
                                @if($seguimiento->imc < 18.5) badge-warning
                                @elseif($seguimiento->imc < 25) badge-success
                                @elseif($seguimiento->imc < 30) badge-warning
                                @else badge-danger
                                @endif">
                                {{ $seguimiento->imc }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $seguimiento->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ $seguimiento->estado }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('seguimientos.show', $seguimiento) }}" 
                               class="btn btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('seguimientos.edit', $seguimiento) }}" 
                               class="btn btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            @if($seguimiento->estado == 'activo')
                                <form action="{{ route('seguimientos.desactivar', $seguimiento) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary" 
                                            title="Desactivar" onclick="return confirm('¿Desactivar este seguimiento?')">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('seguimientos.activar', $seguimiento) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" 
                                            title="Activar" onclick="return confirm('¿Activar este seguimiento?')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('seguimientos.destroy', $seguimiento) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        title="Eliminar" onclick="return confirm('¿Eliminar permanentemente este seguimiento?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <br>No se encontraron seguimientos
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($seguimientos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $seguimientos->links() }}
    </div>
@endif