<?php

class SecurityQuestionPool
{
    private $id;
    private $question;

    public function __construct($question)
    {
        $this->question = $question;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getQuestion()
    {
        return $this->question;
    }
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function save()
    {
        $conn = Database::getConnection();
        if (isset($this->id)) {
            $query = "UPDATE securityQuestionPool SET question = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->question, $this->id]);
        } else {
            $query = "INSERT INTO securityQuestionPool (question) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->question]);
            $this->id = $conn->lastInsertId();
        }
    }

    public static function find($id)
    {
        $query = "SELECT * FROM securityQuestionPool WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $securityQuestion = new SecurityQuestionPool($row['question']);
            $securityQuestion->id = $row['id'];
            return $securityQuestion;
        }
        return null;
    }

    public static function all()
    {
        $query = "SELECT * FROM securityQuestionPool";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $securityQuestions = [];
        foreach ($rows as $row) {
            $securityQuestion = new SecurityQuestionPool($row['question']);
            $securityQuestion->id = $row['id'];
            $securityQuestions[] = $securityQuestion;
        }
        return $securityQuestions;
    }

    public function delete()
    {
        $query = "DELETE FROM securityQuestionPool WHERE id = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute([$this->id]);
    }
}
