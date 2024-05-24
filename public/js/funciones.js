
function buscarPorDni() {
    var dni = document.getElementById('dni').value;


    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/quirurgico/buscarPorDni/' + dni, true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {

            document.getElementById('resultadosContainer').innerHTML = xhr.responseText;
        } else {
            console.error('Error al buscar por DNI. Estado de la solicitud:', xhr.status);
        }
    };
    xhr.send();
}