<?php
$routes = [
    'home' => 'home.php',
];
$view = isset($_GET['view']) ? $_GET['view'] : 'home';
if (!array_key_exists($view, $routes)) {
    $view = '';
}
// Devolver la ruta completa del archivo
return __DIR__ . "/../views/" . $routes[$view];
