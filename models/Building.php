<?php

class Building
{
    private $id;
    private $name;
    private $addressId;
    public function __construct($name, $addressId)
    {
        $this->name = $name;
        $this->addressId = $addressId;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getAddressId()
    {
        return $this->addressId;
    }
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;
    }
    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE building SET name = ?, addressId = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->name, $this->addressId, $this->id]);
        } else {
            $query = "INSERT INTO building (name, addressId) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->name, $this->addressId]);
            $this->id = $conn->lastInsertId();
        }
    }
    public static function find($id)
    {
        $query = "SELECT * FROM building WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $building = new Building($row['name'], $row['addressId']);
            $building->id = $row['id'];
            return $building;
        }
        return null;
    }
    public static function all()
    {
        $query = "SELECT * FROM building";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $buildings = [];
        foreach ($rows as $row) {
            $building = new Building($row['name'], $row['addressId']);
            $building->id = $row['id'];
            $buildings[] = $building;
        }
        return $buildings;
    }
    public function delete()
    {
        $query = "DELETE FROM building WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }
}
