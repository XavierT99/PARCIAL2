<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/Album.php');
error_reporting(0);
$albumes = new Album;

switch ($_GET["op"]) {
    case 'buscar':
        if (!isset($_POST["album_id"])) {
            echo json_encode(["error" => "Album ID not specified."]);
            exit();
        }
        $album_id = intval($_POST["album_id"]);
        $datos = $albumes->buscar($album_id);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'todos':
        $datos = $albumes->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        if (!isset($_POST["album_id"])) {
            echo json_encode(["error" => "Album ID not specified."]);
            exit();
        }
        $album_id = intval($_POST["album_id"]);
        $datos = $albumes->uno($album_id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        if (!isset($_POST["titulo"]) || !isset($_POST["genero"]) || !isset($_POST["anio_lanzamiento"]) || !isset($_POST["discografica"]) || !isset($_POST["artista_id"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $titulo = $_POST["titulo"];
        $genero = $_POST["genero"];
        $anio_lanzamiento = $_POST["anio_lanzamiento"];
        $discografica = $_POST["discografica"];
        $artista_id = intval($_POST["artista_id"]);

        $datos = $albumes->insertar($titulo, $genero, $anio_lanzamiento, $discografica, $artista_id);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["album_id"]) || !isset($_POST["titulo"]) || !isset($_POST["genero"]) || !isset($_POST["anio_lanzamiento"]) || !isset($_POST["discografica"]) || !isset($_POST["artista_id"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $album_id = intval($_POST["album_id"]);
        $titulo = $_POST["titulo"];
        $genero = $_POST["genero"];
        $anio_lanzamiento = $_POST["anio_lanzamiento"];
        $discografica = $_POST["discografica"];
        $artista_id = intval($_POST["artista_id"]);

        $datos = $albumes->actualizar($album_id, $titulo, $genero, $anio_lanzamiento, $discografica, $artista_id);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["album_id"])) {
            echo json_encode(["error" => "Album ID not specified."]);
            exit();
        }
        $album_id = intval($_POST["album_id"]);
        $datos = $albumes->eliminar($album_id);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
