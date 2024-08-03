<?php
session_start();
echo "<br>hii<br>";
require_once '../core/Config.php';
require_once '../models/Person.php';
class ClientController
{
    public function updateInfo()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $personId = $_SESSION['personId'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $phoneNumber = $_POST['phoneNumber'];

            try {
                $person = Person::find($personId);
                if (!$person) {
                    echo 'Error: Person not found.';
                    exit();
                }

                $person->setFirstName($firstName);
                $person->setLastName($lastName);
                $person->setPhoneNumber($phoneNumber);
                $person->save();
                $_SESSION['userFName'] = $person->getFirstName();

                $_SESSION['pushMessage'] = '"Your information has been updated successfully.", "success"';
                header("Location: ../index.php");
                exit();
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            $personId = $_SESSION['personId'];
            $person = Person::find($personId);
            header("Location: ../index.php");
        }
    }
}

$controller = new ClientController();
$controller->updateInfo();
header("Location: ../index.php");
