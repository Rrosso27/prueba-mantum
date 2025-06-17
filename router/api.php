<?php


require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$controller = null;
$response = ['status' => 'error', 'message' => 'Acción no válida'];
header('Content-Type: application/json');


if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getUsuarios':
            $controller = new UsuarioController();
            $response = $controller->index();
            break;
        
        case 'createUsuario':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new UsuarioController();
                $response = $controller->createOrUpdate($_POST);
            } else {
                $response = ['status' => 'error', 'message' => 'Método no permitido'];
            }
            break;

        case 'deleteUsuario':
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $controller = new UsuarioController();
                $response = $controller->delete($_GET['id']);
            } else {
                $response = ['status' => 'error', 'message' => 'Método no permitido'];
            }
            break;

        case 'getUsuarioById':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $controller = new UsuarioController();
                $response = $controller->show($_GET['id']);
            } else {
                $response = ['status' => 'error', 'message' => 'ID de usuario no válido'];
            }
            break;

        default:
            $response = ['status' => 'error', 'message' => 'Ruta no encontrada'];
            break;
    }
}

echo json_encode($response);