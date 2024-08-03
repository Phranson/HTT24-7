<?php

class Person
{
    private $id;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $addressId;
    private $dateOfBirth;

    public function __construct($firstName, $lastName, $phoneNumber, $addressId, $dateOfBirth)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->addressId = $addressId;
        $this->dateOfBirth = $dateOfBirth;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
    public function getAddressId()
    {
        return $this->addressId;
    }
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;
    }
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE person SET firstName = ?, lastName = ?, phoneNumber = ?, addressId = ?, dateOfBirth = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->firstName, $this->lastName, $this->phoneNumber, $this->addressId, $this->dateOfBirth, $this->id]);
        } else {
            $query = "INSERT INTO person (firstName, lastName, phoneNumber, addressId, dateOfBirth) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->firstName, $this->lastName, $this->phoneNumber, $this->addressId, $this->dateOfBirth]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM person WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $person = new Person($row['firstName'], $row['lastName'], $row['phoneNumber'], $row['addressId'], $row['dateOfBirth']);
            $person->id = $row['id'];
            return $person;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM person";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $persons = [];
        foreach ($rows as $row) {
            $person = new Person($row['firstName'], $row['lastName'], $row['phoneNumber'], $row['addressId'], $row['dateOfBirth']);
            $person->id = $row['id'];
            $persons[] = $person;
        }
        return $persons;
    }

    public function delete()
    {
        $query = "DELETE FROM person WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function getAddress()
    {
        return Address::find($this->addressId);
    }

    public static function findByPhoneNumber($phoneNumber)
    {
        $query = "SELECT * FROM person WHERE phoneNumber = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$phoneNumber]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $person = new Person($row['firstName'], $row['lastName'], $row['phoneNumber'], $row['addressId'], $row['dateOfBirth']);
            $person->id = $row['id'];
            return $person;
        }
        return null;
    }
}
