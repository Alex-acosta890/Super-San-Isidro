<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: Login.html");
    exit;
}

$nombre = $_SESSION["nombre"];
$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | San Isidro</title>
<link rel="stylesheet" href="../css/Dashboard.css?v=2">

</head>

<body>

    <header class="topbar">

        <div class="brand">
            <h1>San Isidro</h1>
            <span>Sistema de gestión</span>
        </div>

        <div class="user-info">

    <div>
        <strong><?php echo htmlspecialchars($nombre); ?></strong>
        <span><?php echo htmlspecialchars($rol); ?></span>
    </div>

    <a href="../../controllers/Logout.php" class="logout">
        Cerrar sesión
    </a>

</div>

    </header>


    <main class="dashboard">

        <section class="welcome">

            <p class="welcome-label">Panel principal</p>

            <h2>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h2>

            <p>
                Desde este panel puedes acceder a las diferentes áreas
                de gestión del sistema.
            </p>

        </section>


        <section class="modules">

            <article class="module-card">
                <h3>Usuarios</h3>
                <p>Gestión de usuarios y permisos.</p>
            </article>

            <article class="module-card">
                <h3>Proveedores y Compras</h3>
                <p>Registro y control de compras de materias primas.</p>
            </article>

            <article class="module-card">
                <h3>Inventario</h3>
                <p>Control de materias primas y productos terminados.</p>
            </article>

            <article class="module-card">
                <h3>Producción</h3>
                <p>Gestión de los procesos de producción.</p>
            </article>

            <article class="module-card">
                <h3>Productos</h3>
                <p>Administración de productos y categorías.</p>
            </article>

            <article class="module-card">
                <h3>Ventas y Clientes</h3>
                <p>Control de ventas y clientes.</p>
            </article>

            <article class="module-card">
                <h3>Costos</h3>
                <p>Control de costos y márgenes estimados.</p>
            </article>

            <article class="module-card">
                <h3>Movimientos Especiales</h3>
                <p>Registro de pérdidas, regalías, devoluciones y ajustes.</p>
            </article>

        </section>

    </main>

</body>

</html>