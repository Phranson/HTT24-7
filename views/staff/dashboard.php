<?php
$headerTitle = "Staff Dashboard";
include 'views/includes/header.php';

require_once 'models/Contract.php';
require_once 'models/Client.php';
require_once 'models/Payment.php';
require_once 'models/Services.php';
require_once 'models/ContractVisitSchedule.php';


$services = Services::all();
$contracts = Contract::all();
$clients = Client::all();
$payments = Payment::all();
if (isset($_SESSION["pushMessage"])) {
    echo '<script>pushMessage(' . $_SESSION["pushMessage"] . ')</script>';
    unset($_SESSION["pushMessage"]);
}
?>

<main>
    <div class="staff-panel">
        <h2>Staff Dashboard</h2>

        <div class="dashboardTabContainer">
            <div class="dasshboardTabItem">
                <h3>All Contracts</h3>
                <div class="heightScroller">
                    <?php foreach ($contracts as $contract) { ?>
                        <div class="record">
                            <div><strong>Contract#:</strong> <?php echo $contract->getNumber(); ?></div>
                            <div><strong>Client ID:</strong> <?php echo $contract->getClientId(); ?></div>
                            <div><strong>Ends on:</strong> <?php echo $contract->getEndDate(); ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="dasshboardTabItem">
                <h3>All Clients</h3>
                <div class="heightScroller">
                    <?php foreach ($clients as $client) { ?>
                        <div class="record">
                            <div><strong>Client ID:</strong> <?php echo $client->getId(); ?></div>
                            <div><strong>Name:</strong> <?php echo $client->getFullName(); ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="dasshboardTabItem">
                <h3>All Payments</h3>
                <div class="heightScroller">
                    <?php foreach ($payments as $payment) { ?>
                        <div class="record">
                            <div><strong>Payment ID:</strong> <?php echo $payment->getId(); ?></div>
                            <div><strong>Amount:</strong> <?php echo $payment->getAmount(); ?></div>
                            <div><strong>Date:</strong> <?php echo $payment->getDate(); ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>


        </div>
        <div class="dasshboardTabItemFullWudth">
            <h2>Create New Contract</h2>
            <form action="controllers/ContractController.php" method="post">
                <div class="form-group">
                    <label for="clientId">Client</label>
                    <select id="clientId" name="clientId" required>
                        <?php foreach ($clients as $client) { ?>
                            <option value="<?php echo $client->getId(); ?>"><?php echo $client->getFullName(); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="signerId">Signer</label>
                        <input type="text" id="signerId" name="signerId" required>
                    </div>
                    <div class="form-group">
                        <label for="signerRelationship">Signer Relationship</label>
                        <input type="text" id="signerRelationship" name="signerRelationship" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="patientOverallDescription">Patient Overall Description</label>
                    <textarea id="patientOverallDescription" name="patientOverallDescription" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" name="endDate" required>
                    </div>
                    <div class="form-group">
                        <label for="totalAmount">Total Amount</label>
                        <input type="number" step="0.01" id="totalAmount" name="totalAmount" required>
                    </div>
                </div>

                <button type="submit" class="button">Create Contract</button>
            </form>
        </div>



    </div>
</main>

<?php include 'views/includes/footer.php'; ?>