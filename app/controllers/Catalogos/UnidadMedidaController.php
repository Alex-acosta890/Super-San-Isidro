
<?php
require_once dirname(__DIR__, 3) . "/config/app.php";

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: " . BASE_URL . "/app/views/auth/Login.php");
    exit;
}

require_once ROOT_PATH . "/config/conexion.php";
require_once ROOT_PATH . "/app/models/Catalogos/UnidadMedida.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "/app/views/catalogos/UnidadesMedida.php");
    exit;
}

function regresar(string $tipo, string $mensaje): void
{
    $_SESSION["mensaje_unidad"] = [
        "tipo" => $tipo,
        "texto" => $mensaje
    ];

    header("Location: " . BASE_URL . "/app/views/catalogos/UnidadesMedida.php");
    exit;
}

// Protección CSRF
if (
    !isset($_POST["token"]) ||
    !isset($_SESSION["token_unidad"]) ||
    !hash_equals($_SESSION["token_unidad"], $_POST["token"])
) {
    regresar("error", "La solicitud no es válida. Intente nuevamente.");
}

$accion = $_POST["accion"] ?? "";

try {

    $unidad = new UnidadMedida($conexion);

    switch ($accion) {

        case "registrar":

            $nombre = trim($_POST["nombre"] ?? "");
            $abreviatura = trim($_POST["abreviatura"] ?? "");

            if ($nombre === "" || $abreviatura === "") {
                regresar("error", "Todos los campos son obligatorios.");
            }

            if (strlen($nombre) > 80 || strlen($abreviatura) > 20) {
                regresar("error", "Se superó la longitud permitida de los campos.");
            }

            if ($unidad->existeNombre($nombre)) {
                regresar("error", "Ya existe una unidad con ese nombre.");
            }

            if ($unidad->existeAbreviatura($abreviatura)) {
                regresar("error", "Ya existe una unidad con esa abreviatura.");
            }

            $unidad->registrar($nombre, $abreviatura);

            regresar("exito", "Unidad de medida registrada correctamente.");

        case "actualizar":

            $id = filter_var(
                $_POST["id_unidad"] ?? null,
                FILTER_VALIDATE_INT
            );

            $nombre = trim($_POST["nombre"] ?? "");
            $abreviatura = trim($_POST["abreviatura"] ?? "");

            if (!$id || $id <= 0) {
                regresar("error", "Identificador de unidad inválido.");
            }

            if ($nombre === "" || $abreviatura === "") {
                regresar("error", "Todos los campos son obligatorios.");
            }

            if (strlen($nombre) > 80 || strlen($abreviatura) > 20) {
                regresar("error", "Se superó la longitud permitida de los campos.");
            }

            if (!$unidad->obtenerPorId($id)) {
                regresar("error", "La unidad de medida no existe.");
            }

            if ($unidad->existeNombre($nombre, $id)) {
                regresar("error", "Otra unidad ya utiliza ese nombre.");
            }

            if ($unidad->existeAbreviatura($abreviatura, $id)) {
                regresar("error", "Otra unidad ya utiliza esa abreviatura.");
            }

            $unidad->actualizar($id, $nombre, $abreviatura);

            regresar("exito", "Unidad de medida actualizada correctamente.");

        default:

            regresar("error", "Operación no reconocida.");
    }

} catch (PDOException $e) {

    error_log("Error en unidades de medida: " . $e->getMessage());

    regresar(
        "error",
        "No se pudo completar la operación. Compruebe que no existan datos duplicados o restricciones."
    );
}
