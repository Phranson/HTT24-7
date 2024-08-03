<?php

class SalesTaxClass
{
    private $id;
    private $title;
    private $valueInPercent;

    public function __construct($title, $valueInPercent)
    {
        $this->title = $title;
        $this->valueInPercent = $valueInPercent;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getValueInPercent()
    {
        return $this->valueInPercent;
    }
    public function setValueInPercent($valueInPercent)
    {
        $this->valueInPercent = $valueInPercent;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE salesTaxClass SET title = ?, valueInPercent = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->title, $this->valueInPercent, $this->id]);
        } else {
            $query = "INSERT INTO salesTaxClass (title, valueInPercent) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->title, $this->valueInPercent]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM salesTaxClass WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $salesTaxClass = new SalesTaxClass($row['title'], $row['valueInPercent']);
            $salesTaxClass->id = $row['id'];
            return $salesTaxClass;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM salesTaxClass";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $salesTaxClasses = [];
        foreach ($rows as $row) {
            $salesTaxClass = new SalesTaxClass($row['title'], $row['valueInPercent']);
            $salesTaxClass->id = $row['id'];
            $salesTaxClasses[] = $salesTaxClass;
        }
        return $salesTaxClasses;
    }

    public function delete()
    {
        $query = "DELETE FROM salesTaxClass WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }
}
