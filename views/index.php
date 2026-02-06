<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tareas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Listado de tareas</h2>

<!-- Selector usuario -->
<select id="usuario" class="form-select mb-3">
    <option value="">Seleccione usuario</option>
    <option value="1">Carlos</option>
    <option value="2">Ana</option>
</select>

<!-- Formulario crear tarea -->
<div class="card p-3 mb-3">
    <h4>Nueva tarea</h4>

    <input type="text" id="descripcion" class="form-control mb-2" placeholder="Descripción">

    <select id="proyecto" class="form-select mb-2">
        <option value="1">Sistema ERP</option>
        <option value="2">App móvil</option>
    </select>

    <button onclick="crearTarea()" class="btn btn-success">
        Crear tarea
    </button>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Proyecto</th>
            <th>Descripción</th>
            <th>Valor</th>
        </tr>
    </thead>

    <tbody id="tablaTareas"></tbody>
</table>

<script>

document.getElementById("usuario").addEventListener("change", cargarTareas);

function cargarTareas() {

    let usuario = document.getElementById("usuario").value;

    if(usuario === "") return;

    fetch("../controllers/TareaController.php?usuario_id=" + usuario)
        .then(res => res.json())
        .then(data => {

            let tabla = document.getElementById("tablaTareas");
            tabla.innerHTML = "";

            data.forEach(t => {

                // Multiplicamos por 1000 para convertir 50 -> 50000
                let valor = Number(t.valor) * 1000;

                let valorFormateado = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 0
                }).format(valor);

                tabla.innerHTML += `
                    <tr>
                        <td>${t.usuario}</td>
                        <td>${t.proyecto}</td>
                        <td>${t.descripcion}</td>
                        <td>${valorFormateado}</td>
                    </tr>
                `;
            });

        });
}

function crearTarea() {

    let usuario = document.getElementById("usuario").value;
    let descripcion = document.getElementById("descripcion").value;
    let proyecto = document.getElementById("proyecto").value;

    if(!usuario || !descripcion || !proyecto){
        alert("Debe completar todos los campos");
        return;
    }

    fetch("../controllers/CrearTareaController.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `usuario_id=${usuario}&descripcion=${descripcion}&proyecto_id=${proyecto}`
    })
    .then(res => res.text())
    .then(() => {
        alert("Tarea creada");
        cargarTareas();
    });

}

</script>
