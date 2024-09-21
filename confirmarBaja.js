function confirmarEliminacion(event) {
    let confirmacion = confirm("¿Estás seguro de que deseas eliminarlo?");
    if (!confirmacion) {
        event.preventDefault();
    }
}