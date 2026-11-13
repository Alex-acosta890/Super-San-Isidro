
<?php

require_once dirname(__DIR__, 3) . "/config/app.php";

session_start();

session_unset();
session_destroy();

header("Location: " . BASE_URL . "/app/views/auth/Login.php");
exit;
