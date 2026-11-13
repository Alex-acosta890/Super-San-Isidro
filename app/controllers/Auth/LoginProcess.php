
<?php

require_once dirname(__DIR__, 3) . "/config/app.php";

session_start();

require_once ROOT_PATH . "/config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "/app/views/auth/Login.php");
    exit;
}

$usuario = $_POST["usuario"] ?? "";
$password = $_POST["password"] ?? "";

if ($usuario === "" || $password === "") {
    die("Debe completar todos los campos.");
}

try {

    $sql = "SELECT
                u.id_usuario,
                u.nombre,
                u.usuario,
                u.password,
                u.id_rol,
                r.nombre_rol
            FROM usuarios u
            INNER JOIN roles r
                ON u.id_rol = r.id_rol
            WHERE u.usuario = :usuario";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
        $usuarioEncontrado &&
        password_verify($password, $usuarioEncontrado["password"])
    ) {

        session_regenerate_id(true);

        $_SESSION["id_usuario"] = $usuarioEncontrado["id_usuario"];
        $_SESSION["usuario"] = $usuarioEncontrado["usuario"];
        $_SESSION["nombre"] = $usuarioEncontrado["nombre"];
        $_SESSION["id_rol"] = $usuarioEncontrado["id_rol"];
        $_SESSION["rol"] = $usuarioEncontrado["nombre_rol"];

        header("Location: " . BASE_URL . "/app/views/dashboard/Laesquina.php");
        exit;

    } else {

        die("Usuario o contraseña incorrectos.");

    }

} catch (PDOException $e) {

    error_log("Error al iniciar sesión: " . $e->getMessage());
    die("Error al iniciar sesión.");

}
