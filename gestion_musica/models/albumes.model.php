<?php
// Clase de Álbumes
require_once('../config/config.php');

class Album
{
    public function buscar($album_id) // select * from albumes where album_id = $album_id
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `albumes` WHERE `album_id` = $album_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function todos() // select * from albumes
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `albumes`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($album_id) // select * from albumes where album_id = $album_id
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `albumes` WHERE `album_id` = $album_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($titulo, $genero, $año_lanzamiento, $discografica, $artista_id) // insert into albumes
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `albumes`(`titulo`, `genero`, `año_lanzamiento`, `discografica`, `artista_id`) 
                       VALUES ('$titulo', '$genero', '$año_lanzamiento', '$discografica', '$artista_id')";
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

    public function actualizar($album_id, $titulo, $genero, $año_lanzamiento, $discografica, $artista_id) // update albumes
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `albumes` SET 
                       `titulo`='$titulo',
                       `genero`='$genero',
                       `año_lanzamiento`='$año_lanzamiento',
                       `discografica`='$discografica',
                       `artista_id`='$artista_id'
                       WHERE `album_id` = $album_id";
            if (mysqli_query($con, $cadena)) {
                return $album_id; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($album_id) // delete from albumes where album_id = $album_id
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `albumes` WHERE `album_id`= $album_id";
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
