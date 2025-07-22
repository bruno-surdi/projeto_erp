<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/helpers/functions.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<!-- ✅ MENU GLOBAL -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="index.php">Mini ERP</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="index.php?c=Produto&a=index">Produtos</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?c=Pedido&a=verCarrinho">Carrinho</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?c=Pedido&a=buscarCep">Verificar CEP</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <?php

//    var_dump($_GET);
//    var_dump($_POST);
//    exit;

    // 🔁 Roteamento dinâmico
    $controllerName = $_GET['c'] ?? 'Produto';
    $action = $_GET['a'] ?? 'index';
    $controllerClass = "core\\controllers\\{$controllerName}Controller";

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $action)) {
            call_user_func([$controller, $action]);
        } else {
            http_response_code(404);
            echo "<div class='alert alert-danger'>Método <strong>$action</strong> não encontrado em <code>$controllerClass</code>.</div>";
        }
    } else {
        http_response_code(404);
        echo "<div class='alert alert-danger'>Controller <strong>$controllerClass</strong> não encontrado.</div>";
    }
    ?>
</div>

</body>
</html>
