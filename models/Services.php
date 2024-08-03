<?php

class Services
{
    private $id;
    private $cost;
    private $description;
    private $title;

    public function __construct($id, $cost, $description, $title)
    {
        $this->id = $id;
        $this->cost = $cost;
        $this->description = $description;
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getCost()
    {
        return $this->cost;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getTitle()
    {
        return $this->title;
    }

    public static function find($id)
    {
        $query = "SELECT * FROM services WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Services($row['id'], $row['cost'], $row['description'], $row['title']);
        }
        return null;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE services SET cost = ?, description = ?, title = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->cost, $this->description, $this->title, $this->id]);
        } else {
            $query = "INSERT INTO services (cost, description, title) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->cost, $this->description, $this->title]);
            $this->id = $conn->lastInsertId();
        }
    }

    public function delete()
    {
        $query = "DELETE FROM services WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }

    public static function all()
    {
        $query = "SELECT * FROM services";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $services = [];
        foreach ($rows as $row) {
            $services[] = new Services($row['id'], $row['cost'], $row['description'], $row['title']);
        }
        return $services;
    }
}
