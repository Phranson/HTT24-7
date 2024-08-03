<?php

class ContractVisitSchedule
{
    private $id;
    private $contractNumber;
    private $serviceId;
    private $scheduledVisitorId;
    private $visitAddressId;
    private $dayOfWeek;
    private $time;
    public function __construct($id, $contractNumber, $serviceId, $scheduledVisitorId, $visitAddressId, $dayOfWeek, $time)
    {
        $this->id = $id;
        $this->contractNumber = $contractNumber;
        $this->serviceId = $serviceId;
        $this->scheduledVisitorId = $scheduledVisitorId;
        $this->visitAddressId = $visitAddressId;
        $this->dayOfWeek = $dayOfWeek;
        $this->time = $time;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getContractNumber()
    {
        return $this->contractNumber;
    }
    public function getServiceId()
    {
        return $this->serviceId;
    }
    public function getScheduledVisitorId()
    {
        return $this->scheduledVisitorId;
    }
    public function getVisitAddressId()
    {
        return $this->visitAddressId;
    }
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }
    public function getTime()
    {
        return $this->time;
    }
    public static function findUpcomingByClientId($clientId)
    {
        $query = "
            SELECT cvs.* 
            FROM contractVisitSchedule cvs
            JOIN contract c ON cvs.contractNumber = c.number
            WHERE c.clientId = ? AND cvs.dayOfWeek >= DAYOFWEEK(CURDATE())
            ORDER BY cvs.dayOfWeek, cvs.time
        ";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$clientId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $visits = [];
        foreach ($rows as $row) {
            $visits[] = new ContractVisitSchedule(
                $row['id'],
                $row['contractNumber'],
                $row['serviceId'],
                $row['scheduledVisitorId'],
                $row['visitAddressId'],
                $row['dayOfWeek'],
                $row['time']
            );
        }
        return $visits;
    }
}
