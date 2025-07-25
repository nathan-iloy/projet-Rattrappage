<?php
session_start();

require_once '../config/config.php';

// Routage basique
$url = $_GET['url'] ?? 'patient/dashboard';
$url = rtrim($url, '/');
$url = explode('/', $url);

$controller = $url[0] ?? 'patient';
$method = $url[1] ?? 'dashboard';
$params = array_slice($url, 2);

// Inclure le contrôleur
$controllerFile = APPROOT . '/controllers/' . ucfirst($controller) . 'Controller.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . 'Controller';
    $controllerInstance = new $controllerClass();
    
    if (method_exists($controllerInstance, $method)) {
        call_user_func_array([$controllerInstance, $method], $params);
    } else {
        die('Méthode non trouvée');
    }
} else {
    die('Contrôleur non trouvé');
}
?>