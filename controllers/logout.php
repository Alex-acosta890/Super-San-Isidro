<?php

session_start();

session_unset();
session_destroy();

header("Location: ../assets/html/Login.php");
exit;