<?php

namespace App\Models;

class UsersModel extends Model
{
    protected $id;
    protected $email;
    protected $name;
    protected $password;
    protected $create_at;
    protected $role;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));

    }
    /**
     * Récupérer un user à partir de son e-mail
     * @param string $email
     * @return mixed
     */
    public function findOneByEmail(string $email)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE email = ?", [$email])->fetch();
    }

    /**
     * Crée la session de l'utilisateur
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param $id
     * @return $this
     */
    public function setId($id): UsersModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @param $email
     * @return UsersModel
     */
    public function setEmail($email): UsersModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param $name
     * @return $this
     */
    public function setName($name): UsersModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password): UsersModel
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }


    /**
     * @param $create_at
     * @return $this
     */
    public function setCreateAt($create_at): UsersModel
    {
        $this->create_at = $create_at;
        return $this;
    }


    /**
     * @return array
     */
    public function getRole(): array
    {
        $role = $this->role;
        $role[] ='ROLE_USER';
        return array_unique($role);
    }

    /**
     * @param $role
     * @return $this
     */
    public function setRole($role): UsersModel
    {
        $this->role = json_decode($role);
        return $this;
    }

}
