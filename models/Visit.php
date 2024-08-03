<?php

class Visit
{
    private $id;
    private $scheduledId;
    private $submissionDate;
    private $actualVisitorId;
    private $reportTitle;
    private $reportDescription;

    public function __construct($scheduledId, $submissionDate, $actualVisitorId, $reportTitle, $reportDescription)
    {
        $this->scheduledId = $scheduledId;
        $this->submissionDate = $submissionDate;
        $this->actualVisitorId = $actualVisitorId;
        $this->reportTitle = $reportTitle;
        $this->reportDescription = $reportDescription;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getScheduledId()
    {
        return $this->scheduledId;
    }
    public function setScheduledId($scheduledId)
    {
        $this->scheduledId = $scheduledId;
    }
    public function getSubmissionDate()
    {
        return $this->submissionDate;
    }
    public function setSubmissionDate($submissionDate)
    {
        $this->submissionDate = $submissionDate;
    }
    public function getActualVisitorId()
    {
        return $this->actualVisitorId;
    }
    public function setActualVisitorId($actualVisitorId)
    {
        $this->actualVisitorId = $actualVisitorId;
    }
    public function getReportTitle()
    {
        return $this->reportTitle;
    }
    public function setReportTitle($reportTitle)
    {
        $this->reportTitle = $reportTitle;
    }
    public function getReportDescription()
    {
        return $this->reportDescription;
    }
    public function setReportDescription($reportDescription)
    {
        $this->reportDescription = $reportDescription;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE visit SET scheduledId = ?, submissionDate = ?, actualVisitorId = ?, reportTitle = ?, reportDescription = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->scheduledId, $this->submissionDate, $this->actualVisitorId, $this->reportTitle, $this->reportDescription, $this->id]);
        } else {
            $query = "INSERT INTO visit (scheduledId, submissionDate, actualVisitorId, reportTitle, reportDescription) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->scheduledId, $this->submissionDate, $this->actualVisitorId, $this->reportTitle, $this->reportDescription]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM visit WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $visit = new Visit($row['scheduledId'], $row['submissionDate'], $row['actualVisitorId'], $row['reportTitle'], $row['reportDescription']);
            $visit->id = $row['id'];
            return $visit;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM visit";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $visits = [];
        foreach ($rows as $row) {
            $visit = new Visit($row['scheduledId'], $row['submissionDate'], $row['actualVisitorId'], $row['reportTitle'], $row['reportDescription']);
            $visit->id = $row['id'];
            $visits[] = $visit;
        }
        return $visits;
    }

    public function delete()
    {
        $query = "DELETE FROM visit WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }

    // public function getScheduled()
    // {
    //     return ContractVisitSchedule::find($this->scheduledId);
    // }

    public function getActualVisitor()
    {
        return Staff::find($this->actualVisitorId);
    }
}
