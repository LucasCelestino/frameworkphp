<?php

namespace App\Models;

use App\Helpers\TypeMessage;
use App\Helpers\Messages;

class UserModel extends Model
{
    protected static $safe = ['id', 'created_at', 'updated_at'];

    private static $entity = 'users';

    public function bootstrap(String $name, String $email, String $password): UserModel
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        return $this;
    }

    public function load($id, $columns = '*')
    {
        $load = $this->read("SELECT {$columns} FROM ".self::$entity." WHERE id = :id", "id={$id}");
        
        if($this->fail() || !$load->rowCount())
        {
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find($email, $columns = '*')
    {
        $find = $this->read("SELECT {$columns} FROM ".self::$entity." WHERE email = :email", "email={$email}");

        if($this->fail() || !$find->rowCount())
        {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    public function all($limit = 30, $offset = 0, $columns = '*')
    {
        $all = $this->read("SELECT {$columns} FROM ".self::$entity." LIMIT :limit OFFSET :offset", "limit={$limit}&offset={$offset}");

        if($this->fail() || !$all->rowCount())
        {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save()
    {

        if(!$this->required())
        {
            Messages::sendMessage(TypeMessage::Warning, 'Preencha todos os campos!');
            return null;
        }

        // UPDATE USER
        if(!empty($this->id))
        {
            $userId = $this->id;
    
            $email = $this->read("SELECT id FROM ".self::$entity." WHERE email = :email AND id != :id", "email={$this->email}&id={$userId}");

            if($email->rowCount())
            {
                Messages::sendMessage(TypeMessage::Warning, 'O e-mail informado já está cadastrado.');
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id=:id", "id={$userId}");

            if($this->fail())
            {
                $this->setMessage(Messages::sendMessage(TypeMessage::Error, 'Erro ao atualizar, verifique os dados.'));
                return null;
            }

            $this->setMessage(Messages::sendMessage(TypeMessage::Success, 'Dados atualizados com sucesso!'));
        }
        // CREATE USER
        else
        {
            if($this->find($this->email))
            {
                $this->setMessage(Messages::sendMessage(TypeMessage::Warning, 'O e-mail informado já está cadastrado.'));
                return null;
            }
            else
            {
                $userId = $this->create(self::$entity, $this->safe());
                $this->setMessage(Messages::sendMessage(TypeMessage::Success, 'Usuario criado com sucesso!.'));
            }
        }

        $this->data = $this->read("SELECT * FROM ".self::$entity." WHERE id = :id", "id={$userId}")->fetchObject(__CLASS__);
        return $this;

    }

    public function destroy()
    {
        $destroy = $this->delete(self::$entity, "id = :id", ['id'=>$this->id]);

        if($this->fail() || $destroy == null)
        {
            $this->setMessage(Messages::sendMessage(TypeMessage::Error, 'Erro ao deletar, tente novamente.'));
            return null;
        }
        else
        {
            $this->setMessage(Messages::sendMessage(TypeMessage::Success, 'Usuario deletado com sucesso!'));
        }

        return $this;
    }

    public function required()
    {
        if(!$this->name || !$this->email || !$this->password)
        {
            return false;
        }

        return true;
    }
}