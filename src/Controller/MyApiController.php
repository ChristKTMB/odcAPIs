<?php

namespace Academy\Odcapi\Controller;

use Doctrine\DBAL\Connection;
use function http_response_code;


class MyApiController
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    // Methode qui renvoi les noms des utilisateurs
    public function getUsers(){
    
    $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap";
    $users = $this->conn->executeQuery($sql)->fetchAll();

    if ($users) {
        $response = [
            'success' => true,
            'users' => $users
        ];
        $statusCode = 200;
    } else {
        $response = [
            'success' => false,
            'message' => 'Aucun utilisateur trouvé'
        ];
        $statusCode = 404;
    }

    $responseJson = json_encode($response);
    header('Content-Type: application/json');
    http_response_code($statusCode);

    echo $responseJson;
    }

    // Methode pour permettre au utilisateur de se connecter a notre base de donnée
    public function login($username, $password){

    $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap WHERE username = ? AND password = ?";
    $user = $this->conn->executeQuery($sql, [$username, $password])->fetch();

    if ($user) {
        $response = [
            'success' => true,
            'user' => $user
        ];
        $statusCode = 200;
    } else {
        $response = [
            'success' => false,
            'message' => 'Invalid username or password'
        ];  
        $statusCode = 401;
    }

    $responseJson = json_encode($response);
    // Définir l'en-tête de la réponse pour indiquer que c'est du JSON
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo $responseJson;
    }

    // Methode qui recupere les information d'un utilisateur grace a son nom
    public function getUserByUsername($username){
        
        $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap WHERE username = ?";
        $user = $this->conn->executeQuery($sql, [$username])->fetchAssociative();

        if ($user) {
            $response = [
                'success' => true,
                'user' => $user
            ];
            $statusCode = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'L\'utilisateur n\'a pas été trouvé',
            ];  
            $statusCode = 404;
        }

        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo $responseJson;
    }

    // Methode qui recupere les information d'un utilisateur grace a son nom
    public function getUserByPhone($phone){

        $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap WHERE phone = ?";
        $user = $this->conn->executeQuery($sql, [$phone])->fetch();

        if ($user) {
            $response = [
                'success' => true,
                'user' => $user
            ];
            $statusCode = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'L\'utilisateur n\'a pas été trouvé'
            ];
            $statusCode = 404;
        }

        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo $responseJson;
        }
    
    // Methode qui recupere les information d'un utilisateur grace a son nom de famille
    public function getUserByLastName($lastname){
        
        $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap WHERE last_name = ?";
        $user = $this->conn->executeQuery($sql, [$lastname])->fetchAssociative();
    
        if ($user) {
            $response = [
                'success' => true,
                'user' => $user
            ];
            $statusCode = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'L\'utilisateur n\'a pas été trouvé',
            ];  
            $statusCode = 404;
        }
    
        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo $responseJson;
        }
    
    // Methode qui recupere les information d'un utilisateur grace a son prénom
    public function getUserByFirstName($firstname){
    
        $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap WHERE first_name = ?";
        $user = $this->conn->executeQuery($sql, [$firstname])->fetch();
    
        if ($user) {
            $response = [
                'success' => true,
                'user' => $user
            ];
            $statusCode = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'L\'utilisateur n\'a pas été trouvé'
            ];
            $statusCode = 404;
        }
    
        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo $responseJson;
        }

    // Methode qui recupere les information d'un utilisateur grace a son email
    public function getUserByEmail($email){
    
        $sql = "SELECT id, username, email, first_name, last_name, phone FROM ldap WHERE email = ?";
        $user = $this->conn->executeQuery($sql, [$email])->fetch();
    
        if ($user) {
            $response = [
                'success' => true,
                'user' => $user
            ];
            $statusCode = 200;
        } else {
            $response = [
                'success' => false,
                'message' => 'L\'utilisateur n\'a pas été trouvé'
            ];
            $statusCode = 404;
        }
    
        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo $responseJson;
        }

    // Autres méthodes d'API..
}