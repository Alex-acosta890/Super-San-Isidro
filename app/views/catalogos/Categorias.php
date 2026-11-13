
<?php
require_once dirname(__DIR__, 3) . '/config/app.php';
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: " . BASE_URL . "/app/views/auth/Login.php");
    exit;
}

require_once ROOT_PATH . "/config/conexion.php";
require_once ROOT_PATH . "/app/models/Catalogos/Categoria.php";

if (empty($_SESSION["token_categoria"])) {
    $_SESSION["token_categoria"] = bin2hex(random_bytes(32));
}

$token = $_SESSION["token_categoria"];

$mensaje = $_SESSION["mensaje_categoria"] ?? null;
unset($_SESSION["mensaje_categoria"]);

try {
    $modelo = new Categoria($conexion);
    $categorias = $modelo->obtenerTodas();

    $totalCategorias = count($categorias);
    $activas = count(array_filter(
        $categorias,
        fn($c) => (int)$c["estado"] === 1
    ));
    $inactivas = $totalCategorias - $activas;

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("No fue posible cargar las categorías.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías | San Isidro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="<?= ASSET_URL ?>/css/Catalogos.css?v=<?= filemtime(ROOT_PATH . '/public/assets/css/Catalogos.css') ?>">
</head>

<body>

<div class="catalog-container">

    <header class="catalog-header">
        <div>
            <span class="eyebrow">CONFIGURACI├ôN</span>
            <h1>Categorías de artículos</h1>
            <p>Administra las categorías utilizadas para clasificar los artículos.</p>
        </div>

        <a href="<?= BASE_URL ?>/app/views/dashboard/Laesquina.php" class="btn-secondary">
            Volver al panel
        </a>
    </header>

    <?php if ($mensaje): ?>
        <div class="alert <?= $mensaje["tipo"] === "exito" ? "alert-success" : "alert-error" ?>">
            <?= htmlspecialchars($mensaje["texto"]) ?>
        </div>
    <?php endif; ?>

    <section class="summary-grid">

        <article class="summary-card">
            <span>Total de categorías</span>
            <strong><?= $totalCategorias ?></strong>
        </article>

        <article class="summary-card">
            <span>Categorías activas</span>
            <strong><?= $activas ?></strong>
        </article>

        <article class="summary-card">
            <span>Categorías inactivas</span>
            <strong><?= $inactivas ?></strong>
        </article>

    </section>

    <section class="catalog-panel">

        <div class="panel-heading">
            <div>
                <h2>Listado de categorías</h2>
                <p>Administra los registros de tu cat├ílogo.</p>
            </div>

            <button class="btn-primary" id="btnNuevaCategoria">
                + Nueva categoría
            </button>
        </div>

        <div class="search-container">
            <input
                type="search"
                id="buscarCategoria"
                placeholder="Buscar categoría..."
            >
        </div>

        <div class="table-container">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="tablaCategorias">

                <?php if (empty($categorias)): ?>

                    <tr class="fila-vacia">
                        <td colspan="5">No hay categorías registradas.</td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($categorias as $c): ?>

                        <tr class="fila-categoria">
                            <td><?= (int)$c["id_categoria"] ?></td>

                            <td class="category-name">
                                <?= htmlspecialchars($c["nombre"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($c["descripcion"] ?? "Sin descripción") ?>
                            </td>

                            <td>
                                <?php if ((int)$c["estado"] === 1): ?>
                                    <span class="status active">Activa</span>
                                <?php else: ?>
                                    <span class="status inactive">Inactiva</span>
                                <?php endif; ?>
                            </td>

                            <td class="actions">

                                <button
                                    type="button"
                                    class="btn-edit"
                                    data-id="<?= (int)$c["id_categoria"] ?>"
                                    data-nombre="<?= htmlspecialchars($c["nombre"], ENT_QUOTES, "UTF-8") ?>"
                                    data-descripcion="<?= htmlspecialchars($c["descripcion"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                                >
                                    Editar
                                </button>

                                <form
                                    action="<?= BASE_URL ?>/app/controllers/Catalogos/CategoriaController.php"
                                    method="POST"
                                    onsubmit="return confirm('┬┐Desea cambiar el estado de esta categoría?');"
                                >
                                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                                    <input type="hidden" name="accion" value="cambiar_estado">
                                    <input type="hidden" name="id_categoria" value="<?= (int)$c["id_categoria"] ?>">
                                    <input type="hidden" name="estado" value="<?= (int)$c["estado"] === 1 ? 0 : 1 ?>">

                                    <button type="submit" class="<?= (int)$c["estado"] === 1 ? "btn-disable" : "btn-enable" ?>">
                                        <?= (int)$c["estado"] === 1 ? "Desactivar" : "Activar" ?>
                                    </button>
                                </form>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>
            </table>

            <p id="sinResultados" class="empty-message" hidden>
                No se encontraron categorías.
            </p>

        </div>

        <footer class="table-footer">
            Mostrando <?= $totalCategorias ?> categorías registradas.
        </footer>

    </section>

</div>

<!-- MODAL CATEGOR├ìA -->
<div class="modal-overlay" id="modalCategoria">

    <div class="modal">

        <div class="modal-header">
            <div>
                <span class="eyebrow">GESTI├ôN DE CAT├üLOGOS</span>
                <h2 id="tituloModal">Nueva categoría</h2>
            </div>

            <button type="button" class="btn-close" id="cerrarModal">
                &times;
            </button>
        </div>

        <form
            action="<?= BASE_URL ?>/app/controllers/Catalogos/CategoriaController.php"
            method="POST"
            id="formCategoria"
        >

            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="hidden" name="accion" id="accion" value="registrar">
            <input type="hidden" name="id_categoria" id="idCategoria">

            <div class="form-group">
                <label for="nombre">Nombre de la categoría *</label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    maxlength="100"
                    required
                    placeholder="Ej. Caf├⌐"
                >
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    maxlength="255"
                    rows="4"
                    placeholder="Describe brevemente esta categoría..."
                ></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="cancelarModal">
                    Cancelar
                </button>

                <button type="submit" class="btn-primary" id="btnGuardar">
                    Guardar categoría
                </button>
            </div>

        </form>

    </div>

</div>

<script>
const modal = document.getElementById("modalCategoria");
const formulario = document.getElementById("formCategoria");

const abrirModal = () => {
    modal.classList.add("show");
};

const cerrarModal = () => {
    modal.classList.remove("show");
    formulario.reset();

    document.getElementById("accion").value = "registrar";
    document.getElementById("idCategoria").value = "";

    document.getElementById("tituloModal").textContent = "Nueva categoría";
    document.getElementById("btnGuardar").textContent = "Guardar categoría";
};

document.getElementById("btnNuevaCategoria").addEventListener("click", () => {
    cerrarModal();
    abrirModal();
});

document.getElementById("cerrarModal").addEventListener("click", cerrarModal);
document.getElementById("cancelarModal").addEventListener("click", cerrarModal);

document.querySelectorAll(".btn-edit").forEach(boton => {
    boton.addEventListener("click", () => {

        document.getElementById("accion").value = "actualizar";
        document.getElementById("idCategoria").value = boton.dataset.id;
        document.getElementById("nombre").value = boton.dataset.nombre;
        document.getElementById("descripcion").value = boton.dataset.descripcion;

        document.getElementById("tituloModal").textContent = "Editar categoría";
        document.getElementById("btnGuardar").textContent = "Guardar cambios";

        abrirModal();
    });
});

document.getElementById("buscarCategoria").addEventListener("input", function () {

    const busqueda = this.value.toLowerCase().trim();
    const filas = document.querySelectorAll(".fila-categoria");

    let visibles = 0;

    filas.forEach(fila => {

        const coincide = fila.textContent.toLowerCase().includes(busqueda);

        fila.style.display = coincide ? "" : "none";

        if (coincide) visibles++;
    });

    document.getElementById("sinResultados").hidden = visibles > 0;
});

modal.addEventListener("click", evento => {
    if (evento.target === modal) cerrarModal();
});

document.addEventListener("keydown", evento => {
    if (evento.key === "Escape") cerrarModal();
});
</script>

</body>
</html>