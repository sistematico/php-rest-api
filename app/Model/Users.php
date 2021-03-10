<?php

//require_once('config.php');
require_once('core/db.php');
require_once('core/response.php');

$response = new \Api\Core\Response();

try {
    $conn = new \Api\Core\Db();
    $db = $conn->db;
} catch (PDOException $ex) {
    $response->setResponse(false, 500, "Database connection error");
    $response->send();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response->setResponse(false, 405, "Request method not allowed");
    $response->send();
    exit;
}

if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
    $response->setResponse(false, 400, "Content Type header not set to JSON");
    $response->send();
    exit;
}

$rawPostData = file_get_contents('php://input');

if (!$jsonData = json_decode($rawPostData)) {
    $response->setResponse(false, 400, "Request body is not valid JSON");
    $response->send();
    exit;
}

if (!isset($jsonData->fullname) || !isset($jsonData->username) || !isset($jsonData->password)) {
    $msg[] = (!isset($jsonData->fullname) ? "Full name not supplied" : "");
    $msg[] = (!isset($jsonData->username) ? "Username not supplied" : "");
    $msg[] = (!isset($jsonData->password) ? "Password not supplied" : "");
    $response->setResponse(false, 400, $msg);
    $response->send();
    exit;
}

if (strlen($jsonData->fullname) < 1 || strlen($jsonData->fullname) > 255 || strlen($jsonData->username) < 1 || strlen($jsonData->username) > 255 || strlen($jsonData->password) < 1 || strlen($jsonData->password) > 100) {
    $msg[] = (strlen($jsonData->fullname) < 1 ? "Full name cannot be blank" : "");
    $msg[] = (strlen($jsonData->fullname) > 255 ? "Full name cannot be greater than 255 characters" : "");
    $msg[] = (strlen($jsonData->username) < 1 ? "Username cannot be blank" : "");
    $msg[] = (strlen($jsonData->username) > 255 ? "Username cannot be greater than 255 characters" : "");
    $msg[] = (strlen($jsonData->password) < 1 ? "Password cannot be blank" : "");
    $msg[] = (strlen($jsonData->password) > 100 ? "Password cannot be greater than 100 characters" : "");
    $response->setResponse(false, 400, $msg);
    $response->send();
    exit;
}

$fullname = trim($jsonData->fullname);
$username = trim($jsonData->username);
$password = $jsonData->password;

try {
    $query = $db->prepare('SELECT id from tblusers where username = :username');
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();

    if ($query->fetch()) {
        $response->setResponse(false, 409, "Username already exists");
        $response->send();
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = $db->prepare('INSERT into tblusers (fullname, username, password) values (:fullname, :username, :password)');
    $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $query->execute();

    $query = $db->query('SELECT COUNT(id) from tblusers');
    $rowCount = $query->fetch(PDO::FETCH_NUM);

    if ($rowCount === 0) {
        $response->setResponse(false, 500, "There was an error creating the user account - please try again");
        $response->send();
        exit;
    }

    $lastUserID = $db->lastInsertId();
    $returnData = ['user_id' => $lastUserID, 'fullname' => $fullname, 'username' => $username];

    $response->setResponse(true, 201, "User created", $returnData);
    $response->send();
    exit;
} catch (PDOException $ex) {
    $response->setResponse(false, 500, "There was an issue creating a user account - please try again: " . $ex->getMessage());
    $response->send();
    exit;
}
