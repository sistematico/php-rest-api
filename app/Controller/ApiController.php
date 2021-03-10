<?php

namespace App\Controller;

use App\Model\Api;
use App\Core\Response;

class ApiController
{
    private $data;
    private $json;

    public function __construct()
    {     
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::setResponse(false, 405, "Request method not allowed");
            Response::send();
            exit;
        }
        
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            Response::setResponse(false, 400, "Content Type header not set to JSON");
            Response::send();
            exit;
        }
        
        $this->data = file_get_contents('php://input');     
        
        if (!$this->json = json_decode($this->data)) {
            Response::setResponse(false, 400, "Request body is not valid JSON");
            Response::send();
            exit;
        }
    }

    public function install()
    {
        $Api = new Api();
        $api = $Api->install();
        Response::setResponse(true, 201, $api);
        Response::send();
        exit;
    }

    public function users()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Api = new Api();
            $api = $Api->users();
        } else {
            $this->notAllowed();
        }
        Response::setResponse(true, 201, $api);
        Response::send();
        exit;
    }

    public function notAllowed() {
        Response::setResponse(false, 405, "Request method not allowed");
        Response::send();
        exit;
    }
}