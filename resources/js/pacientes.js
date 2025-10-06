// Validación del formulario de pacientes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pacienteForm');
    const fields = form.querySelectorAll('input, select, textarea');
    
    // Validación en tiempo real
    fields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    // Validación del formulario al enviar
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        fields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Por favor, corrige los errores en el formulario.', 'error');
        }
    });
    
    // Función para validar campo individual
    function validateField(field) {
        const value = field.value.trim();
        const pattern = field.pattern;
        const isRequired = field.required;
        
        // Limpiar validaciones anteriores
        field.classList.remove('is-invalid', 'is-valid');
        
        // Validar campo requerido
        if (isRequired && !value) {
            field.classList.add('is-invalid');
            return false;
        }
        
        // Validar patrón si existe
        if (pattern && value) {
            const regex = new RegExp(pattern);
            if (!regex.test(value)) {
                field.classList.add('is-invalid');
                return false;
            }
        }
        
        // Validaciones específicas por tipo de campo
        if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            
            if (selectedDate > today) {
                field.classList.add('is-invalid');
                return false;
            }
        }
        
        // Si pasa todas las validaciones
        if (value || !isRequired) {
            field.classList.add('is-valid');
        }
        
        return true;
    }
    
    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        // Puedes integrar SweetAlert o tu sistema de notificaciones aquí
        console.log(`${type}: ${message}`);
    }
    
    // Máscara para teléfono
    const telefonoInput = document.getElementById('tutor_telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d+\-\s]/g, '');
            e.target.value = value;
        });
    }
    
    // Máscara para CI (solo números)
    const ciInputs = ['CI', 'tutor_CI'];
    ciInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });
        }
    });
    
    // Máscara para nombres (solo letras y espacios)
    const nameInputs = ['nombre', 'apellido_paterno', 'apellido_materno', 
                       'tutor_nombre', 'tutor_apellido_paterno', 'tutor_apellido_materno'];
    nameInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^a-zA-Z\sáéíóúÁÉÍÓÚñÑ]/g, '');
                e.target.value = value;
            });
        }
    });
});