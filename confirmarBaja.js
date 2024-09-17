function confirmarEliminacion(event) {
    var confirmacion = confirm("¿Estás seguro de que deseas eliminarlo?");
    if (!confirmacion) {
        event.preventDefault();
    }
}