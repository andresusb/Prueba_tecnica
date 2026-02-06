<?php

require_once "../config/database.php";

$usuario_id = $_GET['usuario_id'];

$sql = "SELECT 
            u.nombre AS usuario,
            p.nombre AS proyecto,
            t.descripcion,
            IFNULL(up.tarifa, 0) AS valor
        FROM tareas t
        JOIN usuarios u ON t.usuario_id = u.id
        JOIN proyectos p ON t.proyecto_id = p.id
        LEFT JOIN usuario_proyecto up 
            ON up.usuario_id = u.id 
            AND up.proyecto_id = p.id
        WHERE u.id = ?";

$stmt = $conexion->prepare($sql);
$stmt->execute([$usuario_id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
