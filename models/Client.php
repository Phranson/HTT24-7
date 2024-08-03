<?php

class Client
{
    private $id;
    private $personId;
    private $insuranceCompany;
    private $emergencyContactId;
    private $clientCat;
    public function __construct($id, $personId, $insuranceCompany, $emergencyContactId, $clientCat)
    {
        $this->id = $id;
        $this->personId = $personId;
        $this->insuranceCompany = $insuranceCompany;
        $this->emergencyContactId = $emergencyContactId;
        $this->clientCat = $clientCat;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getPersonId()
    {
        return $this->personId;
    }
    public function getInsuranceCompany()
    {
        return $this->insuranceCompany;
    }
    public function getEmergencyContactId()
    {
        return $this->emergencyContactId;
    }
    public function getClientCat()
    {
        return $this->clientCat;
    }
    public static function all()
    {
        $query = "SELECT * FROM client";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clients = [];
        foreach ($rows as $row) {
            $clients[] = new Client(
                $row['id'],
                $row['personId'],
                $row['insuranceCompany'],
                $row['emergencyContactId'],
                $row['clientCat']
            );
        }
        return $clients;
    }
    public static function find($id)
    {
        $query = "SELECT * FROM client WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Client(
                $row['id'],
                $row['personId'],
                $row['insuranceCompany'],
                $row['emergencyContactId'],
                $row['clientCat']
            );
        }
        return null;
    }
    public function save()
    {
        $conn = Database::getConnection();
        if ($this->id) {
            $query = "UPDATE client SET personId = ?, insuranceCompany = ?, emergencyContactId = ?, clientCat = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->personId, $this->insuranceCompany, $this->emergencyContactId, $this->clientCat, $this->id]);
        } else {
            $query = "INSERT INTO client (personId, insuranceCompany, emergencyContactId, clientCat) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->personId, $this->insuranceCompany, $this->emergencyContactId, $this->clientCat]);
            $this->id = $conn->lastInsertId();
        }
    }
    public function delete()
    {
        $query = "DELETE FROM client WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }
    public function getFullName()
    {
        $query = "SELECT firstName, lastName FROM person WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->personId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['firstName'] . ' ' . $row['lastName'];
        }
        return null;
    }
}
