<?php

require_once "../config/database.php";

$usuario_id = $_POST['usuario_id'];
$descripcion = $_POST['descripcion'];
$proyecto_id = $_POST['proyecto_id'];

try {

    // Verificar si existe relación usuario-proyecto
    $verificar = $conexion->prepare("
        SELECT * FROM usuario_proyecto 
        WHERE usuario_id = ? AND proyecto_id = ?
    ");

    $verificar->execute([$usuario_id, $proyecto_id]);

    if($verificar->rowCount() == 0){

        // Si no existe, la creamos con tarifa por defecto
        $crearRelacion = $conexion->prepare("
            INSERT INTO usuario_proyecto (usuario_id, proyecto_id, tarifa)
            VALUES (?, ?, 50)
        ");

        $crearRelacion->execute([$usuario_id, $proyecto_id]);
    }

    // Insertar tarea
    $sql = "INSERT INTO tareas (usuario_id, proyecto_id, descripcion)
            VALUES (?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario_id, $proyecto_id, $descripcion]);

    echo "ok";

} catch(Exception $e){

    echo "error: " . $e->getMessage();
}
