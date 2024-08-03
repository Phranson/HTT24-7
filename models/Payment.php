<?php

class Payment
{
    private $id;
    private $invoiceId;
    private $method;
    private $date;
    private $amount;
    private $dueDate;

    public function __construct($invoiceId, $method, $date, $amount, $dueDate)
    {
        $this->invoiceId = $invoiceId;
        $this->method = $method;
        $this->date = $date;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function setMethod($method)
    {
        $this->method = $method;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function getDueDate()
    {
        return $this->dueDate;
    }
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE payment SET invoiceId = ?, method = ?, date = ?, amount = ?, dueDate = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->invoiceId, $this->method, $this->date, $this->amount, $this->dueDate, $this->id]);
        } else {
            $query = "INSERT INTO payment (invoiceId, method, date, amount, dueDate) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->invoiceId, $this->method, $this->date, $this->amount, $this->dueDate]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM payment WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $payment = new Payment($row['invoiceId'], $row['method'], $row['date'], $row['amount'], $row['dueDate']);
            $payment->id = $row['id'];
            return $payment;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM payment";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $payments = [];
        foreach ($rows as $row) {
            $payment = new Payment($row['invoiceId'], $row['method'], $row['date'], $row['amount'], $row['dueDate']);
            $payment->id = $row['id'];
            $payments[] = $payment;
        }
        return $payments;
    }

    public function delete()
    {
        $query = "DELETE FROM payment WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function getInvoice()
    {
        return Invoice::find($this->invoiceId);
    }
}
