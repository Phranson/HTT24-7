<?php

class Office
{
    private $id;
    private $buildingId;
    private $roomNumber;
    private $phoneNumber;

    public function __construct($buildingId, $roomNumber, $phoneNumber)
    {
        $this->buildingId = $buildingId;
        $this->roomNumber = $roomNumber;
        $this->phoneNumber = $phoneNumber;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getBuildingId()
    {
        return $this->buildingId;
    }
    public function setBuildingId($buildingId)
    {
        $this->buildingId = $buildingId;
    }
    public function getRoomNumber()
    {
        return $this->roomNumber;
    }
    public function setRoomNumber($roomNumber)
    {
        $this->roomNumber = $roomNumber;
    }
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE office SET buildingId = ?, roomNumber = ?, phoneNumber = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->buildingId, $this->roomNumber, $this->phoneNumber, $this->id]);
        } else {
            $query = "INSERT INTO office (buildingId, roomNumber, phoneNumber) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->buildingId, $this->roomNumber, $this->phoneNumber]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM office WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $office = new Office($row['buildingId'], $row['roomNumber'], $row['phoneNumber']);
            $office->id = $row['id'];
            return $office;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM office";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $offices = [];
        foreach ($rows as $row) {
            $office = new Office($row['buildingId'], $row['roomNumber'], $row['phoneNumber']);
            $office->id = $row['id'];
            $offices[] = $office;
        }
        return $offices;
    }

    public function delete()
    {
        $query = "DELETE FROM office WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }
}
