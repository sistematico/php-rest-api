<?php

namespace App\Controller;

use App\Model\User;
use App\Core\Response;

class UserController
{
    private $data;
    private $json;

    public function __construct()
    {   
       
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkContentType();
            $this->data = file_get_contents('php://input');     
        
            if (!$this->json = json_decode($this->data)) {
                Response::setResponse(false, 400, "O corpo da requisição não é um JSON válido.");
                Response::send();
                exit;
            }
            
        } else if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
            $this->checkContentType();
            $this->data = file_get_contents('php://input');     
        
            if (!$this->json = json_decode($this->data)) {
                Response::setResponse(false, 400, "O corpo da requisição não é um JSON válido.");
                Response::send();
                exit;
            }
            
        //} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

        //} else if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            
        }
        //else {
        //    $this->notAllowed();
        //}
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $User = new User();
        $user = $User->list();
        Response::setResponse($user['sucess'], $user['statusCode'], $user['message'], $user['list']);
        Response::send();
        exit;
    }

    public function insert()
    {
        $json = $this->json;
        $User = new User();
        $user = $User->insert($json->fullname, $json->username, $json->email, $json->password);
        Response::setResponse($user['sucess'], $user['statusCode'], $user['message']);
        Response::send();
        exit;
    }

    public function update($id)
    {
        $json = $this->json;
        $User = new User();
        $user = $User->update($id, $json->fullname, $json->username, $json->email, $json->password);
        Response::setResponse($user['sucess'], $user['statusCode'], $user['message']);
        Response::send();
        exit;
    }

    public function delete($id)
    {
        $User = new User();
        $user = $User->delete($id);        
        Response::setResponse($user['sucess'], $user['statusCode'], $user['message']);
        Response::send();        
        exit;
    }

    public function install()
    {
        $User = new User();
        $user = $User->install();
        Response::setResponse($user['sucess'], $user['statusCode'], $user['message']);
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
}