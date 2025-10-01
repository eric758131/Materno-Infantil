import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
document.addEventListener('DOMContentLoaded', function() {
    const botonMenu = document.querySelector('.boton-menu');
    const barraLateral = document.querySelector('.barra-lateral');
    
    botonMenu.addEventListener('click', function() {
        barraLateral.classList.toggle('colapsada');
    });
});