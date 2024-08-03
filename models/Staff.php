<?php

class Staff
{
    private $id;
    private $officeId;
    private $personId;
    private $SSNSIN;
    private $HMRN;

    public function __construct($officeId, $personId, $SSNSIN, $HMRN)
    {
        $this->officeId = $officeId;
        $this->personId = $personId;
        $this->SSNSIN = $SSNSIN;
        $this->HMRN = $HMRN;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getOfficeId()
    {
        return $this->officeId;
    }
    public function setOfficeId($officeId)
    {
        $this->officeId = $officeId;
    }
    public function getPersonId()
    {
        return $this->personId;
    }
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }
    public function getSSNSIN()
    {
        return $this->SSNSIN;
    }
    public function setSSNSIN($SSNSIN)
    {
        $this->SSNSIN = $SSNSIN;
    }
    public function getHMRN()
    {
        return $this->HMRN;
    }
    public function setHMRN($HMRN)
    {
        $this->HMRN = $HMRN;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE staff SET officeId = ?, personId = ?, SSNSIN = ?, HMRN = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->officeId, $this->personId, $this->SSNSIN, $this->HMRN, $this->id]);
        } else {
            $query = "INSERT INTO staff (officeId, personId, SSNSIN, HMRN) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->officeId, $this->personId, $this->SSNSIN, $this->HMRN]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM staff WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $staff = new Staff($row['officeId'], $row['personId'], $row['SSNSIN'], $row['HMRN']);
            $staff->id = $row['id'];
            return $staff;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM staff";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $staffs = [];
        foreach ($rows as $row) {
            $staff = new Staff($row['officeId'], $row['personId'], $row['SSNSIN'], $row['HMRN']);
            $staff->id = $row['id'];
            $staffs[] = $staff;
        }
        return $staffs;
    }

    public function delete()
    {
        $query = "DELETE FROM staff WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function getPerson()
    {
        return Person::find($this->personId);
    }

    public function getOffice()
    {
        return Office::find($this->officeId);
    }
}
