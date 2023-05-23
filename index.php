<?php

require_once 'vendor/autoload.php';
$config = require 'config.php';

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Academy\Odcapi\Controller\MyApiController;


// Configuration de Doctrine DBAL
$dbConfig = new Configuration();
$connectionParams = $config['db']; 
$conn = DriverManager::getConnection($connectionParams, $dbConfig);


// Vérifier si une méthode a été spécifiée dans l'URL

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  if (isset($_GET['method'])) {
    $method = $_GET['method'];

    // Créer une instance de votre contrôleur
    $apiController = new MyApiController($conn);

    switch ($method) {
        case 'getUsers':
            $response = $apiController->getUsers();
            break;
        case 'getUserByUsername':
            if (isset($_GET['username'])) {
                $username = $_GET['username'];
                $response = $apiController->getUserByUsername($username);
            } else {
                $response = 'Invalid parameter';
            }
            break;
        case 'getUserByEmail':
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                $response = $apiController->getUserByEmail($email);
            } else {
                $response = 'Invalid parameter';
            }
            break;
        default:
            // La méthode spécifiée n'est pas prise en charge
            $response = 'Invalid method';
            $statusCode = 405;
            break;
    }
    $responseJson = json_encode($response);
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo $responseJson;
  }

}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (isset($_GET['method'])) {
    $method = $_GET['method'];

    // Créer une instance de votre contrôleur
    $apiController = new MyApiController($conn);

    switch ($method) {
        case 'login':
            $requestData = json_decode(file_get_contents('php://input'), true);
  
            if (isset($requestData['username']) && isset($requestData['password'])) {
                $username = $requestData['username'];
                $password = $requestData['password'];
                $response = $apiController->login($username, $password);
            } else {
                $response = 'Invalid parameters';
            }
            break;
        default:
            // La méthode spécifiée n'est pas prise en charge
            $response = 'Invalid method';
            $statusCode = 405;
            break;
        }
        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo $responseJson;
    }   
}else{
        http_response_code(405);
        echo json_encode(['message' => 'Type de requête non autorisé.']);
}