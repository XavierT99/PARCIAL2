<?php
// Clase de Artistas
require_once('../config/config.php');

class Artista
{
    public function buscar($artista_id) // select * from artistas where artista_id = $artista_id
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `artistas` WHERE `artista_id` = $artista_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function todos() // select * from artistas
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `artistas`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($artista_id) // select * from artistas where artista_id = $artista_id
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `artistas` WHERE `artista_id` = $artista_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($nombre, $apellido, $fecha_nacimiento, $nacionalidad) // insert into artistas
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `artistas`(`nombre`, `apellido`, `fecha_nacimiento`, `nacionalidad`) 
                       VALUES ('$nombre', '$apellido', '$fecha_nacimiento', '$nacionalidad')";
            if (mysqli_query($con, $cadena)) {
                return $con->insert_id; // Return the inserted ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function actualizar($artista_id, $nombre, $apellido, $fecha_nacimiento, $nacionalidad) // update artistas
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `artistas` SET 
                       `nombre`='$nombre',
                       `apellido`='$apellido',
                       `fecha_nacimiento`='$fecha_nacimiento',
                       `nacionalidad`='$nacionalidad'
                       WHERE `artista_id` = $artista_id";
            if (mysqli_query($con, $cadena)) {
                return $artista_id; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($artista_id) // delete from artistas where artista_id = $artista_id
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `artistas` WHERE `artista_id`= $artista_id";
            if (mysqli_query($con, $cadena)) {
                return 1; // Success
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }
}
