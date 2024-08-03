<?php

class Address
{
    private $id;
    private $unitNumber;
    private $streetNumber;
    private $city;
    private $stateProvince;
    private $country;
    private $postalCode;

    public function __construct($unitNumber, $streetNumber, $city, $stateProvince, $country, $postalCode)
    {
        $this->unitNumber = $unitNumber;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->stateProvince = $stateProvince;
        $this->country = $country;
        $this->postalCode = $postalCode;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;
    }
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function getStateProvince()
    {
        return $this->stateProvince;
    }
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE address SET unitNumber = ?, streetNumber = ?, city = ?, stateProvince = ?, country = ?, postalCode = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->unitNumber, $this->streetNumber, $this->city, $this->stateProvince, $this->country, $this->postalCode, $this->id]);
        } else {
            $query = "INSERT INTO address (unitNumber, streetNumber, city, stateProvince, country, postalCode) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->unitNumber, $this->streetNumber, $this->city, $this->stateProvince, $this->country, $this->postalCode]);
            $this->id = $conn->lastInsertId();
        }
    }
    public static function find($id)
    {
        $query = "SELECT * FROM address WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $address = new Address($row['unitNumber'], $row['streetNumber'], $row['city'], $row['stateProvince'], $row['country'], $row['postalCode']);
            $address->id = $row['id'];
            return $address;
        }
        return null;
    }
    public static function all()
    {
        $query = "SELECT * FROM address";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $addresses = [];
        foreach ($rows as $row) {
            $address = new Address($row['unitNumber'], $row['streetNumber'], $row['city'], $row['stateProvince'], $row['country'], $row['postalCode']);
            $address->id = $row['id'];
            $addresses[] = $address;
        }
        return $addresses;
    }
    public function delete()
    {
        $query = "DELETE FROM address WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }
}
