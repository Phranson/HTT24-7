<?php

class ServiceContract
{
    private $contractId;
    private $serviceId;

    public function __construct($contractId, $serviceId)
    {
        $this->contractId = $contractId;
        $this->serviceId = $serviceId;
    }

    public function getContractId()
    {
        return $this->contractId;
    }
    public function setContractId($contractId)
    {
        $this->contractId = $contractId;
    }
    public function getServiceId()
    {
        return $this->serviceId;
    }
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    public function save()
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO serviceContract (contractId, serviceId) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$this->contractId, $this->serviceId]);
    }

    public static function find($contractId, $serviceId)
    {
        $query = "SELECT * FROM serviceContract WHERE contractId = ? AND serviceId = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$contractId, $serviceId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ServiceContract($row['contractId'], $row['serviceId']);
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM serviceContract";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $serviceContracts = [];
        foreach ($rows as $row) {
            $serviceContract = new ServiceContract($row['contractId'], $row['serviceId']);
            $serviceContracts[] = $serviceContract;
        }
        return $serviceContracts;
    }

    public function delete()
    {
        $query = "DELETE FROM serviceContract WHERE contractId = ? AND serviceId = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->contractId, $this->serviceId]);
    }
}
