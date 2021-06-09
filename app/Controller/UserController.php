<?php

namespace App\Controller;

use App\Model\User;
use App\Core\Response;

class UserController
{
    private array $json;

    public function __construct()
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PATCH' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->checkContentType();
            $this->json = json_decode(file_get_contents('php://input'), true);
            $this->invalidJson($this->json);
        }
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $User = new User();
        $user = $User->list();
        Response::setResponse($user['success'], $user['statusCode'], $user['message'], $user['list']);
        Response::send();
        exit;
    }

    public function add()
    {
        $User = new User();
        $user = $User->add($this->json);
        Response::setResponse($user['success'], $user['statusCode'], $user['message']);
        Response::send();
        exit;
    }

    public function update($id)
    {
        if (!isset($id)) {
            Response::setResponse(false, 400, 'User ID not supplied.');
            Response::send();
            exit;
        }

        $User = new User();
        $user = $User->update($id, $this->json);
        Response::setResponse($user['success'], $user['statusCode'], $user['message']);
        Response::send();
        exit;
    }

    public function delete($id)
    {
        if (!isset($id)) {
            Response::setResponse(false, 400, 'User ID not supplied.');
            Response::send();
            exit;
        }

        $User = new User();
        $user = $User->delete($id);        
        Response::setResponse($user['success'], $user['statusCode'], $user['message']);
        Response::send();        
        exit;
    }

    public function install()
    {
        $User = new User();
        $user = $User->install();
        Response::setResponse($user['success'], $user['statusCode'], $user['message']);
        Response::send();
        exit;
    }

    public function notAllowed() {
        Response::setResponse(false, 405, "Método da requisição não autorizado.");
        Response::send();
        exit;
    }

    public function checkContentType() {
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            Response::setResponse(false, 400, "O tipo de conteúdo precisa ser no formato JSON.");
            Response::send();
            exit;
        }
    }

    public function invalidJson($json) {
        if (!isset($json) || empty($json) || $json === null) {
            Response::setResponse(false, 400, "O corpo da requisição não é um JSON válido.");
            Response::send();
            exit;
        }
    }
}