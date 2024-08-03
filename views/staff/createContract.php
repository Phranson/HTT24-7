<?php
$headerTitle = "Create New Contract";
include 'views/includes/header.php';

require_once 'models/Client.php';
require_once 'models/Services.php';

$clients = Client::all();
$services = Services::all();
if (isset($_SESSION["pushMessage"])) {
    echo '<script>pushMessage(' . $_SESSION["pushMessage"] . ')</script>';
    unset($_SESSION["pushMessage"]);
}
?>
<main>
    <div class="formContainer">
        <h2>Create New Contract</h2>
        <form action="process_create_contract.php" method="post">
            <div class="form-group">
                <label for="clientId">Client</label>
                <select id="clientId" name="clientId" required>
                    <?php foreach ($clients as $client) { ?>
                        <option value="<?php echo $client->getId(); ?>"><?php echo $client->getFullName(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="signerId">Signer</label>
                <input type="text" id="signerId" name="signerId" required>
            </div>
            <div class="form-group">
                <label for="signerRelationship">Signer Relationship</label>
                <input type="text" id="signerRelationship" name="signerRelationship" required>
            </div>
            <div class="form-group">
                <label for="patientOverallDescription">Patient Overall Description</label>
                <textarea id="patientOverallDescription" name="patientOverallDescription" required></textarea>
            </div>
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
            <button type="submit" class="button">Create Contract</button>
        </form>
    </div>
</main>

<?php include 'views/includes/footer.php'; ?>