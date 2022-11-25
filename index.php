<?php

session_start();
include_once("configuration/Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();

// $router->redirect($_GET['controller'], isset($_GET['method']) ?? $_GET['method']);
$router->redirect($_GET['controller'], $_GET['method'] ?? '');
