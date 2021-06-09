<?php

namespace App\Model;

use App\Model\Jwt;
use App\Core\Database;
use PDO;
use PDOException;

class User extends Database
{
    const VALID = 3600;
    private array $data = [];

    public function install(): array
    {
        if (!file_exists(SQL_FILE))
            return ['success' => false, 'statusCode' => 500, 'message' => 'Impossível encontrar o arquivo SQL.'];
        try {
            $sql = file_get_contents(SQL_FILE);
            $this->db->exec($sql);
        } catch (PDOException $e) {
            return ['success' => false, 'statusCode' => 500, 'message' => 'Erro ao instalar o arquivo SQL, mensagem de erro: ' . $e->getMessage()];
        }

        return ['success' => true, 'statusCode' => 201, 'message' => 'Sucesso ao instalar as tabelas do banco de dados.'];
    }

    public function list(): array
    {
        $rows = $this->db->query('SELECT * FROM users');
        while($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            array_push($this->data, $row);
        }
        return ['success' => true, 'statusCode' => 201, 'message' => 'Lista de usuários.', 'list' => $this->data];
    }

    public function add(array $params): array
    {
        foreach ($params as $key => $value) {
            if (empty($params[$key])) {
                return ['success' => false, 'statusCode' => 500, 'message' => "{$key} não pode estar vazio."];
            }
        }

        extract($params);

        try {
            $stmt = $this->db->prepare('INSERT INTO users (fullname, username, email, password, secret) VALUES (:fullname, :username, :email, :password, :secret)');
            $stmt->execute([':fullname' => $fullname, ':username' => $username, ':email' => $email, ':password' => $password, ':secret' => $secret]);
            return ['success' => true, 'statusCode' => 201, 'message' => 'Sucesso ao inserir os dados.'];
        } catch (PDOException $e) {
            return ['success' => false, 'statusCode' => 500, 'message' => "Erro ao inserir usuário: " . $e->getMessage()];
        }

        return ['success' => false, 'statusCode' => 500, 'message' => 'Erro ao inserir dados.'];
    }

    public function update(int $id, array $params): array
    {
        foreach ($params as $key => $value) {
            if (empty($params[$key]))
                return ['success' => false, 'statusCode' => 500, 'message' => "{$key} não pode estar vazio."];
        }

        extract($params);

        try {
            $stmt = $this->db->prepare("UPDATE users SET fullname = :fullname, username = :username, email = :email, password = :password WHERE id = :id");
            $stmt->execute([':id' => $id, ':fullname' => $fullname, ':username' => $username, ':email' => $email, ':password' => $password]);
            return ['success' => true, 'statusCode' => 201, 'message' => 'Sucesso ao atualizar os dados.'];
        } catch (PDOException $e) {
            unset($e);
            return ['success' => false, 'statusCode' => 500, 'message' => 'Erro ao atualizar usuário.'];
        }

        return ['success' => false, 'statusCode' => 500, 'message' => 'Erro ao atualizar dados.'];
    }

    public function delete($id): array
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() === 1)
                return ['success' => true, 'statusCode' => 201, 'message' => "Sucesso ao apagar o ID: {$id}."];
        } catch (PDOException $e) {
            return ['success' => false, 'statusCode' => 500, 'message' => "Erro ao apagar o id: {$id}: " . $e->getMessage()];
        }

        return ['success' => false, 'statusCode' => 500, 'message' => "Erro ao apagar o ID: {$id}, possivelmente este id não existe."];
    }

    // public function signup($fullname, $username, $email, $password, $secret): array
    // {
    //     if ($this->userNotExist($username, $email))
    //         return ['success' => false, 'statusCode' => 401, 'message' => 'Usuário e/ou e-mail já existem.'];

    //     $this->add($fullname, $username, $email, $password, $secret);
    // }

    public function signin($login, $password): array
    {
        if (!$user = $this->user($login, $password))
            return ['success' => false, 'statusCode' => 401, 'message' => 'Usuário não encontrado ou senha incorreta.'];

        return ['success' => true, 'statusCode' => 201, 'message' => 'Usuário logado com sucesso.', 'token' => $this->createToken($user['id'], $user['secret'])];
    }

    public function user($login, $password): array
    {
        try {
            $stmt = $this->db->prepare("SELECT id, fullname, username, email, password, secret, active FROM users WHERE username = :username AND password = :password LIMIT 1");
            $stmt->execute([':username' => $login, ':password' => $password]);
            if ($user = $stmt->fetch(PDO::FETCH_ASSOC))
                if (password_verify($password, $user['password']))
                    return $user;
        } catch (PDOException $e) {
            return false;
        }

        return false;
    }

    public function userNotExist($login, $email): bool
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1");
            $stmt->execute([':username' => $login, ':email' => $email]);
            if (!$stmt->fetch(PDO::FETCH_ASSOC))
                return true;
        } catch (PDOException $e) {
            return false;
        }

        return false;
    }

    function getToken($secret)
    {
        $headers = getallheaders();

        if (array_key_exists('Authorization', $headers))
            return false;

        $token = Jwt::decode($headers['Authorization'], $secret);

        if ($token->exp <= time())
            return false;
         
        return $token->id;
    }

    function createToken($id, $secret)
    {
        $token = ['id' => $id, 'exp' => time() + self::VALID];
        return json_encode(['token' => Jwt::encode($token, $secret)]);
    }
}
