<?php

namespace App\Model;

use App\Core\Database;
use App\Core\Response;

class User extends Database
{
    private array $data = [];

    public function install(): array
    {
        if (!file_exists(SQL_FILE))
            return ['sucess' => false, 'statusCode' => 500, 'message' => 'Impossível encontrar o arquivo SQL.'];
        try {
            $sql = file_get_contents(SQL_FILE);
            $this->db->exec($sql);
        } catch (\PDOException $e) {
            return ['sucess' => false, 'statusCode' => 500, 'message' => 'Erro ao instalar o arquivo SQL, mensagem de erro: ' . $e->getMessage()];
        }

        return ['sucess' => true, 'statusCode' => 201, 'message' => 'Sucesso ao instalar as tabelas do banco de dados.'];
    }

    public function list(): array
    {
        $rows = $this->db->query('SELECT * FROM users');
        while($row = $rows->fetch(\PDO::FETCH_ASSOC)) {
            array_push($this->data, $row);
        }
        return ['sucess' => true, 'statusCode' => 201, 'message' => 'Lista de usuários.', 'list' => $this->data];
    }

    public function insert($fullname, $username, $email, $password): array
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO users (fullname, username, email, password) VALUES (:fullname, :username, :email, :password)');
            $stmt->execute([':fullname' => $fullname, ':username' => $username, ':email' => $email, ':password' => $password]);
            return ['sucess' => true, 'statusCode' => 201, 'message' => 'Sucesso ao inserir os dados.'];
        } catch (\PDOException $e) {
            unset($e);
            //return ['sucess' => false, 'statusCode' => 500, 'message' => "Erro ao inserir dados: " . $e->getMessage()];
            return ['sucess' => false, 'statusCode' => 500, 'message' => 'Erro ao inserir usuário, possivelmente usuário ou senha já existem.'];
        }

        return ['sucess' => false, 'statusCode' => 500, 'message' => 'Erro ao inserir dados.'];
    }

    public function update($id, $fullname, $username, $email, $password): array
    {
        try {
            $stmt = $this->db->prepare('UPDATE users SET fullname = :fullname, username = :username, email = :email, password = :password WHERE id = :id)');
            $stmt->execute([':id' => $id, ':fullname' => $fullname, ':username' => $username, ':email' => $email, ':password' => $password]);
            return ['sucess' => true, 'statusCode' => 201, 'message' => 'Sucesso ao atualizar os dados.'];
        } catch (\PDOException $e) {
            unset($e);
            return ['sucess' => false, 'statusCode' => 500, 'message' => 'Erro ao atualizar usuário.'];
        }

        return ['sucess' => false, 'statusCode' => 500, 'message' => 'Erro ao atualizar dados.'];
    }

    public function delete($id): array
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM users WHERE id LIKE :id');
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() === 1)
                return ['sucess' => true, 'statusCode' => 201, 'message' => "Sucesso ao apagar o ID: {$id}."];
        } catch (\PDOException $e) {
            return ['sucess' => false, 'statusCode' => 500, 'message' => "Erro ao apagar o id: {$id}: " . $e->getMessage()];
        }

        return ['sucess' => false, 'statusCode' => 500, 'message' => "Erro ao apagar o ID: {$id}, possivelmente este id não existe."];
    }
}