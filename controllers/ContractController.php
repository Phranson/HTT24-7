<?php
require_once '../core/Config.php';
require_once '../models/Contract.php';
require_once '../models/Person.php';

class ContractController
{
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $clientId = intval($_POST['clientId']);
            $signerId = intval($_POST['signerId']);
            $signerRelationship = $_POST['signerRelationship'];
            $patientOverallDescription = $_POST['patientOverallDescription'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $totalAmount = floatval($_POST['totalAmount']);

            $signer = Person::find($signerId);
            if (!$signer) {
                echo 'Error: Signer not found.';
                exit();
            }

            try {
                $contract = new Contract(null, $clientId, $signerId, $signerRelationship, $patientOverallDescription, $startDate, $endDate, $totalAmount);
                $contract->save();

                $_SESSION['pushMessage'] = '"New contract has been created successfully.", "success"';
                header("Location: ../index.php");
                exit();
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }
}

$controller = new ContractController();
$controller->create();
