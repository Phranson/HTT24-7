<?php

class Contract
{
    private $number;
    private $clientId;
    private $signerId;
    private $signerRelationship;
    private $patientOverallDescription;
    private $startDate;
    private $endDate;
    private $totalAmount;
    public function __construct($number, $clientId, $signerId, $signerRelationship, $patientOverallDescription, $startDate, $endDate, $totalAmount)
    {
        $this->number = $number;
        $this->clientId = $clientId;
        $this->signerId = $signerId;
        $this->signerRelationship = $signerRelationship;
        $this->patientOverallDescription = $patientOverallDescription;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->totalAmount = $totalAmount;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function getClientId()
    {
        return $this->clientId;
    }
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }
    public function getSignerId()
    {
        return $this->signerId;
    }
    public function setSignerId($signerId)
    {
        $this->signerId = $signerId;
    }
    public function getSignerRelationship()
    {
        return $this->signerRelationship;
    }
    public function setSignerRelationship($signerRelationship)
    {
        $this->signerRelationship = $signerRelationship;
    }
    public function getPatientOverallDescription()
    {
        return $this->patientOverallDescription;
    }
    public function setPatientOverallDescription($patientOverallDescription)
    {
        $this->patientOverallDescription = $patientOverallDescription;
    }
    public function getStartDate()
    {
        return $this->startDate;
    }
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    public function getEndDate()
    {
        return $this->endDate;
    }
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }
    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->number)) {
            $query = "UPDATE contract SET clientId = ?, signerId = ?, signerRelationship = ?, patientOverallDescription = ?, startDate = ?, endDate = ?, totalAmount = ? WHERE number = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->clientId, $this->signerId, $this->signerRelationship, $this->patientOverallDescription, $this->startDate, $this->endDate, $this->totalAmount, $this->number]);
        } else {
            $query = "INSERT INTO contract (clientId, signerId, signerRelationship, patientOverallDescription, startDate, endDate, totalAmount) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->clientId, $this->signerId, $this->signerRelationship, $this->patientOverallDescription, $this->startDate, $this->endDate, $this->totalAmount]);
            $this->number = $conn->lastInsertId();
        }
    }

    public static function findByClientId($clientId)
    {
        $query = "SELECT * FROM contract WHERE clientId = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$clientId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contracts = [];
        foreach ($rows as $row) {
            $contract = new Contract(
                $row['number'],
                $row['clientId'],
                $row['signerId'],
                $row['signerRelationship'],
                $row['patientOverallDescription'],
                $row['startDate'],
                $row['endDate'],
                $row['totalAmount']
            );
            $contracts[] = $contract;
        }
        return $contracts;
    }

    public static function find($number)
    {
        $query = "SELECT * FROM contract WHERE number = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$number]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Contract(
                $row['number'],
                $row['clientId'],
                $row['signerId'],
                $row['signerRelationship'],
                $row['patientOverallDescription'],
                $row['startDate'],
                $row['endDate'],
                $row['totalAmount']
            );
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM contract";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contracts = [];
        foreach ($rows as $row) {
            $contract = new Contract(
                $row['number'],
                $row['clientId'],
                $row['signerId'],
                $row['signerRelationship'],
                $row['patientOverallDescription'],
                $row['startDate'],
                $row['endDate'],
                $row['totalAmount']
            );
            $contracts[] = $contract;
        }
        return $contracts;
    }

    public function delete()
    {
        $query = "DELETE FROM contract WHERE number = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->number]);
    }

    public function getClient()
    {
        return Client::find($this->clientId);
    }

    public function getSigner()
    {
        return Person::find($this->signerId);
    }
}
