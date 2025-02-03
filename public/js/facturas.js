function cargarDatos() {
    var producto = document.getElementById('producto').value;
    console.log(producto);
    
    fetch(`Facturas/cargardatos?nombre=${encodeURIComponent(producto)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('nombre').value = data.nombre || '';
            document.getElementById('descripcion').value = data.descripcion || '';
            document.getElementById('precio').value = data.precio || 0;
            calcularTotal();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

    function calcularTotal() {
        var cantidad = document.getElementById('cantidad').value;
        var precio = document.getElementById('precio').value;
        var total = cantidad * precio;
        document.getElementById('total').value = total.toFixed(2);
    }