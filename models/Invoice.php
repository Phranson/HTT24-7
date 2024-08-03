<?php

class Invoice
{
    private $id;
    private $contractId;
    private $issueDate;
    private $taxClassId;

    public function __construct($contractId, $issueDate, $taxClassId)
    {
        $this->contractId = $contractId;
        $this->issueDate = $issueDate;
        $this->taxClassId = $taxClassId;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getContractId()
    {
        return $this->contractId;
    }
    public function setContractId($contractId)
    {
        $this->contractId = $contractId;
    }
    public function getIssueDate()
    {
        return $this->issueDate;
    }
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;
    }
    public function getTaxClassId()
    {
        return $this->taxClassId;
    }
    public function setTaxClassId($taxClassId)
    {
        $this->taxClassId = $taxClassId;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE invoice SET contractId = ?, issueDate = ?, taxClassId = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->contractId, $this->issueDate, $this->taxClassId, $this->id]);
        } else {
            $query = "INSERT INTO invoice (contractId, issueDate, taxClassId) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->contractId, $this->issueDate, $this->taxClassId]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM invoice WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $invoice = new Invoice($row['contractId'], $row['issueDate'], $row['taxClassId']);
            $invoice->id = $row['id'];
            return $invoice;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM invoice";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $invoices = [];
        foreach ($rows as $row) {
            $invoice = new Invoice($row['contractId'], $row['issueDate'], $row['taxClassId']);
            $invoice->id = $row['id'];
            $invoices[] = $invoice;
        }
        return $invoices;
    }

    public function delete()
    {
        $query = "DELETE FROM invoice WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function getContract()
    {
        return Contract::find($this->contractId);
    }

    public function getTaxClass()
    {
        return SalesTaxClass::find($this->taxClassId);
    }
}
