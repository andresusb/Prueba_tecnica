<?php

class Tarea {

    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function obtenerTareasPorUsuario($usuario_id) {

        $query = "SELECT 
                    u.nombre AS usuario,
                    p.nombre AS proyecto,
                    t.descripcion,
                    t.horas_trabajadas,
                    up.tarifa,
                    (t.horas_trabajadas * up.tarifa) AS valor_total
                  FROM tareas t
                  JOIN usuarios u ON t.usuario_id = u.id
                  JOIN proyectos p ON t.proyecto_id = p.id
                  JOIN usuario_proyecto up 
                        ON up.usuario_id = u.id 
                        AND up.proyecto_id = p.id
                  WHERE u.id = :usuario_id";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
