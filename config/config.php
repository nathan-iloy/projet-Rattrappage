<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'clinique_rv');

// Configuration de l'application
define('APPROOT', dirname(dirname(__FILE__)));
define('URLROOT', 'http://localhost/clinique-rv');
define('SITENAME', 'Clinique RV');

// Autoload des classes
spl_autoload_register(function($className) {
    require_once APPROOT . '/models/' . $className . '.php';
});

// Fonctions utilitaires
function loadView($view, $data = []) {
    extract($data);
    require_once APPROOT . '/views/' . $view . '.php';
}

function redirect($url) {
    header('Location: ' . URLROOT . '/' . $url);
    exit();
}

function flash($name, $message = '') {
    if (!empty($message)) {
        $_SESSION[$name] = $message;
    } else {
        $message = $_SESSION[$name] ?? '';
        unset($_SESSION[$name]);
        return $message;
    }
}
?>
