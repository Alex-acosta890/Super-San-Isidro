
<?php
require_once dirname(__DIR__, 3) . '/config/app.php';
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: " . BASE_URL . "/app/views/auth/Login.php");
    exit;
}

require_once ROOT_PATH . "/config/conexion.php";
require_once ROOT_PATH . "/app/models/Catalogos/UnidadMedida.php";

if (empty($_SESSION["token_unidad"])) {
    $_SESSION["token_unidad"] = bin2hex(random_bytes(32));
}

$token = $_SESSION["token_unidad"];

$mensaje = $_SESSION["mensaje_unidad"] ?? null;
unset($_SESSION["mensaje_unidad"]);

try {
    $modelo = new UnidadMedida($conexion);
    $unidades = $modelo->obtenerTodas();
    $totalUnidades = count($unidades);

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("No fue posible cargar las unidades de medida.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidades de medida | San Isidro</title>

    <link rel="stylesheet" href="<?= ASSET_URL ?>/css/Catalogos.css?v=<?= filemtime(ROOT_PATH . '/public/assets/css/Catalogos.css') ?>">
</head>

<body>

    <main class="catalogo-container">

        <header class="catalogo-header">
            <div>
                <span class="catalogo-etiqueta">CAT├üLOGOS</span>
                <h1>Unidades de medida</h1>
                <p>Administra las unidades utilizadas en las operaciones del sistema.</p>
            </div>

            <button class="btn-principal" id="btnNuevaUnidad">
                + Nueva unidad
            </button>
        </header>

        <?php if ($mensaje): ?>
            <div class="alerta <?= htmlspecialchars($mensaje["tipo"]) ?>">
                <?= htmlspecialchars($mensaje["texto"]) ?>
            </div>
        <?php endif; ?>

        <section class="catalogo-estadisticas">

            <article class="estadistica-card">
                <div class="estadistica-icono"></div>
                <div>
                    <span>Total de unidades</span>
                    <strong><?= $totalUnidades ?></strong>
                </div>
            </article>

        </section>

        <section class="catalogo-contenido">

            <div class="contenido-header">
                <div>
                    <h2>Unidades registradas</h2>
                    <p>Listado de unidades de medida disponibles.</p>
                </div>

                <div class="buscador-container">
                    <input
                        type="search"
                        id="buscarUnidad"
                        placeholder="Buscar unidad..."
                        autocomplete="off"
                    >
                </div>
            </div>

            <div class="tabla-responsive">
                <table class="tabla-catalogo">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Abreviatura</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaUnidades">

                        <?php if (empty($unidades)): ?>

                            <tr>
                                <td colspan="4" class="tabla-vacia">
                                    No hay unidades de medida registradas.
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($unidades as $unidad): ?>

                                <tr>
                                    <td>
                                        #<?= (int)$unidad["id_unidad"] ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($unidad["nombre"]) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <span class="abreviatura-badge">
                                            <?= htmlspecialchars($unidad["abreviatura"]) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="acciones-tabla">

                                            <button
                                                type="button"
                                                class="btn-editar"
                                                data-id="<?= (int)$unidad["id_unidad"] ?>"
                                                data-nombre="<?= htmlspecialchars($unidad["nombre"], ENT_QUOTES, 'UTF-8') ?>"
                                                data-abreviatura="<?= htmlspecialchars($unidad["abreviatura"], ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                                Editar
                                            </button>

                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>
                </table>

                <div id="sinResultados" class="tabla-vacia" hidden>
                    No se encontraron unidades que coincidan con la b├║squeda.
                </div>
            </div>

        </section>

    </main>


    <!-- MODAL REGISTRAR / EDITAR -->

    <div class="modal-overlay" id="modalUnidad">

        <div class="modal-contenido">

            <div class="modal-header">
                <div>
                    <span class="catalogo-etiqueta">CAT├üLOGO</span>
                    <h2 id="tituloModal">Nueva unidad de medida</h2>
                </div>

                <button type="button" class="btn-cerrar" id="btnCerrarModal">
                    &times;
                </button>
            </div>

            <form
                action="<?= BASE_URL ?>/app/controllers/Catalogos/UnidadMedidaController.php"
                method="POST"
                id="formUnidad"
            >

                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <input type="hidden" name="accion" id="accionUnidad" value="registrar">

                <input type="hidden" name="id_unidad" id="idUnidad">

                <div class="form-grupo">
                    <label for="nombreUnidad">Nombre de la unidad</label>

                    <input
                        type="text"
                        id="nombreUnidad"
                        name="nombre"
                        maxlength="80"
                        placeholder="Ej. Kilogramo"
                        required
                    >
                </div>

                <div class="form-grupo">
                    <label for="abreviaturaUnidad">Abreviatura</label>

                    <input
                        type="text"
                        id="abreviaturaUnidad"
                        name="abreviatura"
                        maxlength="20"
                        placeholder="Ej. kg"
                        required
                    >
                </div>

                <div class="modal-acciones">

                    <button type="button" class="btn-secundario" id="btnCancelar">
                        Cancelar
                    </button>

                    <button type="submit" class="btn-principal">
                        Guardar unidad
                    </button>

                </div>

            </form>

        </div>

    </div>


    <script>

        const modal = document.getElementById("modalUnidad");
        const form = document.getElementById("formUnidad");

        const tituloModal = document.getElementById("tituloModal");
        const accionUnidad = document.getElementById("accionUnidad");
        const idUnidad = document.getElementById("idUnidad");

        const nombreUnidad = document.getElementById("nombreUnidad");
        const abreviaturaUnidad = document.getElementById("abreviaturaUnidad");


        function abrirModal() {
            modal.classList.add("activo");
            nombreUnidad.focus();
        }

        function cerrarModal() {
            modal.classList.remove("activo");

            form.reset();

            accionUnidad.value = "registrar";
            idUnidad.value = "";

            tituloModal.textContent = "Nueva unidad de medida";
        }


        document.getElementById("btnNuevaUnidad").addEventListener("click", () => {

            cerrarModal();
            abrirModal();

        });


        document.getElementById("btnCerrarModal").addEventListener("click", cerrarModal);

        document.getElementById("btnCancelar").addEventListener("click", cerrarModal);


        document.querySelectorAll(".btn-editar").forEach(boton => {

            boton.addEventListener("click", () => {

                accionUnidad.value = "actualizar";

                idUnidad.value = boton.dataset.id;
                nombreUnidad.value = boton.dataset.nombre;
                abreviaturaUnidad.value = boton.dataset.abreviatura;

                tituloModal.textContent = "Editar unidad de medida";

                abrirModal();

            });

        });


        modal.addEventListener("click", (evento) => {

            if (evento.target === modal) {
                cerrarModal();
            }

        });


        document.addEventListener("keydown", (evento) => {

            if (evento.key === "Escape" && modal.classList.contains("activo")) {
                cerrarModal();
            }

        });


        // B├║squeda en tiempo real

        const buscador = document.getElementById("buscarUnidad");
        const filas = document.querySelectorAll("#tablaUnidades tr");
        const sinResultados = document.getElementById("sinResultados");

        buscador.addEventListener("input", () => {

            const termino = buscador.value.toLowerCase().trim();
            let encontrados = 0;

            filas.forEach(fila => {

                const contenido = fila.textContent.toLowerCase();

                if (contenido.includes(termino)) {
                    fila.hidden = false;
                    encontrados++;
                } else {
                    fila.hidden = true;
                }

            });

            sinResultados.hidden = encontrados > 0;

        });

    </script>

</body>
</html>