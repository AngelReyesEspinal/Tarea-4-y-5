<?php
    session_start();
    session_destroy();
    header('Location: http://localhost/web/tarea4y5/index.php');
?>