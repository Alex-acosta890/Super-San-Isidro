
<?php

require_once dirname(__DIR__, 3) . "/config/app.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión | San Isidro</title>

    <link
        rel="stylesheet"
        href="<?= ASSET_URL ?>/css/Login.css?v=<?= filemtime(ROOT_PATH . '/public/assets/css/Login.css') ?>"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >
</head>

<body>

    <div class="wrapper">

        <form action="<?= BASE_URL ?>/app/controllers/Auth/LoginProcess.php" method="POST">

            <h2>Bienvenido/a</h2>

            <div class="input-field">
                <input
                    type="text"
                    name="usuario"
                    placeholder="Usuario (Ej: Admin)"
                    required
                >
            </div>

            <div class="input-field password-container">
                <input
                    type="password"
                    id="passwordInput"
                    name="password"
                    placeholder="Contraseña"
                    required
                >

                <span id="togglePassword" class="toggle-password">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </span>
            </div>

            <button type="submit">Iniciar Sesión</button>

            <img
                src="<?= ASSET_URL ?>/images/isidro1.png"
                alt="Logo"
                class="logo"
            >

        </form>

    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#passwordInput');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {

            const isPassword = passwordInput.getAttribute('type') === 'password';

            if (isPassword) {
                passwordInput.setAttribute('type', 'text');
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.setAttribute('type', 'password');
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }

        });
    </script>

</body>
</html>
