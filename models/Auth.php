<?php

class Auth
{
    private $userName;
    private $password;
    private $personId;
    private $secQuestion1;
    private $secQ1Answer;
    private $secQuestion2;
    private $secQ2Answer;
    private $roleId;
    public function __construct($userName, $password, $personId, $secQuestion1, $secQ1Answer, $secQuestion2, $secQ2Answer, $roleId)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->personId = $personId;
        $this->secQuestion1 = $secQuestion1;
        $this->secQ1Answer = $secQ1Answer;
        $this->secQuestion2 = $secQuestion2;
        $this->secQ2Answer = $secQ2Answer;
        $this->roleId = $roleId;
    }
    public function getUserName()
    {
        return $this->userName;
    }
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPersonId()
    {
        return $this->personId;
    }
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }
    public function getSecQuestion1()
    {
        return $this->secQuestion1;
    }
    public function setSecQuestion1($secQuestion1)
    {
        $this->secQuestion1 = $secQuestion1;
    }
    public function getSecQ1Answer()
    {
        return $this->secQ1Answer;
    }
    public function setSecQ1Answer($secQ1Answer)
    {
        $this->secQ1Answer = $secQ1Answer;
    }
    public function getSecQuestion2()
    {
        return $this->secQuestion2;
    }
    public function setSecQuestion2($secQuestion2)
    {
        $this->secQuestion2 = $secQuestion2;
    }
    public function getSecQ2Answer()
    {
        return $this->secQ2Answer;
    }
    public function setSecQ2Answer($secQ2Answer)
    {
        $this->secQ2Answer = $secQ2Answer;
    }
    public function getRoleId()
    {
        return $this->roleId;
    }
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->userName)) {
            $query = "UPDATE auth SET password = ?, personId = ?, secQuestion1 = ?, secQ1Answer = ?, secQuestion2 = ?, secQ2Answer = ?, roleId = ? WHERE userName = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->password, $this->personId, $this->secQuestion1, $this->secQ1Answer, $this->secQuestion2, $this->secQ2Answer, $this->roleId, $this->userName]);
        } else {
            $query = "INSERT INTO auth (userName, password, personId, secQuestion1, secQ1Answer, secQuestion2, secQ2Answer, roleId) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->userName, $this->password, $this->personId, $this->secQuestion1, $this->secQ1Answer, $this->secQuestion2, $this->secQ2Answer, $this->roleId]);
        }
    }
    public static function find($userName)
    {
        $query = "SELECT * FROM auth WHERE userName = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$userName]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Auth($row['userName'], $row['password'], $row['personId'], $row['secQuestion1'], $row['secQ1Answer'], $row['secQuestion2'], $row['secQ2Answer'], $row['roleId']);
        }
        return null;
    }
    public static function all()
    {
        $query = "SELECT * FROM auth";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $auths = [];
        foreach ($rows as $row) {
            $auth = new Auth($row['userName'], $row['password'], $row['personId'], $row['secQuestion1'], $row['secQ1Answer'], $row['secQuestion2'], $row['secQ2Answer'], $row['roleId']);
            $auths[] = $auth;
        }
        return $auths;
    }
    public function delete()
    {
        $query = "DELETE FROM auth WHERE userName = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->userName]);
    }
    public function login($userName, $password)
    {
        $auth = self::find($userName);
        if ($auth) {
            if (password_verify($password, $auth->getPassword())) {
                session_start();
                $_SESSION['userName'] = $auth->getUserName();
                $_SESSION['personId'] = $auth->getPersonId();
                $_SESSION['userRole'] = $auth->getRoleId();

                $person = Person::find($auth->getPersonId());
                if ($person) {
                    $_SESSION['userFName'] = $person->getFirstName();
                    $_SESSION['userId'] = $person->getId();
                }
                return 0; // success
            } else {
                return 2; // Incorrect password
            }
        } else {
            return 1; // Usrename wrong
        }
    }
}
