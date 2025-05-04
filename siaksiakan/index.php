<?php
require_once 'Config/Database.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'student';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllers = [
    'student' => 'StudentController',
    'course' => 'CourseController',
    'enrollment' => 'EnrollmentController'
];

if (!array_key_exists($controller, $controllers)) {
    $controller = 'student';
}

$controllerClass = $controllers[$controller];
$controllerFile = 'Controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerObject = new $controllerClass();
    
    if (method_exists($controllerObject, $action)) {
        $controllerObject->$action();
    } else {
        $controllerObject->index();
    }
} else {
    echo 'Controller not found: ' . $controllerClass;
}