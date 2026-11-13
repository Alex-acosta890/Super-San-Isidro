
<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../../assets/html/Login.php");
    exit;
}

require_once "../../config/conexion.php";
require_once "../../models/Categoria.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../assets/html/Categorias.php");
    exit;
}

function regresar(string $tipo, string $mensaje): void
{
    $_SESSION["mensaje_categoria"] = [
        "tipo" => $tipo,
        "texto" => $mensaje
    ];

    header("Location: ../../assets/html/Categorias.php");
    exit;
}

// Protección CSRF
if (
    !isset($_POST["token"]) ||
    !isset($_SESSION["token_categoria"]) ||
    !hash_equals($_SESSION["token_categoria"], $_POST["token"])
) {
    regresar("error", "La solicitud no es válida. Intente nuevamente.");
}

$accion = $_POST["accion"] ?? "";

try {

    $categoria = new Categoria($conexion);

    switch ($accion) {

        case "registrar":

            $nombre = trim($_POST["nombre"] ?? "");
            $descripcion = trim($_POST["descripcion"] ?? "");

            if ($nombre === "") {
                regresar("error", "El nombre es obligatorio.");
            }

            if (strlen($nombre) > 100) {
                regresar("error", "El nombre no puede superar los 100 caracteres.");
            }

            if (strlen($descripcion) > 255) {
                regresar("error", "La descripción no puede superar los 255 caracteres.");
            }

            if ($categoria->existeNombre($nombre)) {
                regresar("error", "Ya existe una categoría con ese nombre.");
            }

            $categoria->registrar(
                $nombre,
                $descripcion !== "" ? $descripcion : null
            );

            regresar("exito", "Categoría registrada correctamente.");

        case "actualizar":

            $id = filter_var(
                $_POST["id_categoria"] ?? null,
                FILTER_VALIDATE_INT
            );

            $nombre = trim($_POST["nombre"] ?? "");
            $descripcion = trim($_POST["descripcion"] ?? "");

            if (!$id || $id <= 0) {
                regresar("error", "Identificador de categoría inválido.");
            }

            if ($nombre === "") {
                regresar("error", "El nombre es obligatorio.");
            }

            if (strlen($nombre) > 100 || strlen($descripcion) > 255) {
                regresar("error", "Se superó la longitud permitida.");
            }

            if (!$categoria->obtenerPorId($id)) {
                regresar("error", "La categoría no existe.");
            }

            if ($categoria->existeNombre($nombre, $id)) {
                regresar("error", "Otra categoría ya utiliza ese nombre.");
            }

            $categoria->actualizar(
                $id,
                $nombre,
                $descripcion !== "" ? $descripcion : null
            );

            regresar("exito", "Categoría actualizada correctamente.");

        case "cambiar_estado":

            $id = filter_var(
                $_POST["id_categoria"] ?? null,
                FILTER_VALIDATE_INT
            );

            $estado = filter_var(
                $_POST["estado"] ?? null,
                FILTER_VALIDATE_INT
            );

            if (!$id || $id <= 0 || !in_array($estado, [0, 1], true)) {
                regresar("error", "Datos de estado inválidos.");
            }

            $registro = $categoria->obtenerPorId($id);

            if (!$registro) {
                regresar("error", "La categoría no existe.");
            }

            if ((int)$registro["estado"] === $estado) {
                regresar("error", "La categoría ya tiene ese estado.");
            }

            $categoria->cambiarEstado($id, $estado);

            $mensaje = $estado === 1
                ? "Categoría activada correctamente."
                : "Categoría desactivada correctamente.";

            regresar("exito", $mensaje);

        default:

            regresar("error", "Operación no reconocida.");
    }

} catch (PDOException $e) {

    if ($e->getCode() === "23000") {
        regresar("error", "No se pudo completar la operación. Compruebe que no existan datos duplicados o restricciones.");
    }

    error_log("Error en categorías: " . $e->getMessage());

    regresar("error", "Ocurrió un error al procesar la categoría.");
}
