<?php
$headerTitle = "Client Dashboard";
include 'views/includes/header.php';

require_once 'models/Contract.php';
require_once 'models/Services.php';
require_once 'models/ContractVisitSchedule.php';
$currClientId = $_SESSION['userId'];
$contracts = Contract::findByClientId($currClientId);
$upcomingVisits = ContractVisitSchedule::findUpcomingByClientId($currClientId);

$personId = $_SESSION['personId'];
$person = Person::find($personId);



if (isset($_SESSION["pushMessage"])) {
    echo '<script>pushMessage(' . $_SESSION["pushMessage"] . ')</script>';
    unset($_SESSION["pushMessage"]);
}


?>

<main>
    <div class="client-panel">
        <h2>Client Dashboard</h2>
        <div class="dashboardTabContainer">
            <div class="dasshboardTabItem">
                <h3>contracts</h3>
                <div class="heightScroller">
                    <?php
                    foreach ($contracts as $contract) { ?>
                        <div class="record">
                            <div><strong>Contract#:</strong><?php echo $contract->getNumber(); ?></div>
                            <div><strong>Ends on </strong><?php echo $contract->getEndDate(); ?></div>
                        </div>
                    <?php };
                    ?>
                </div>
            </div>
            <div class="dasshboardTabItem">
                <h3>Upcomming sessions</h3>

                <div class="heightScroller">
                    <?php
                    foreach ($upcomingVisits as $upcomingVisit) {
                        $service = Services::find($upcomingVisit->getServiceId());
                    ?>
                        <div class="record">
                            <div><strong></strong><?php echo $service->getTitle(); ?></div>
                            <div><strong> on </strong><?php echo $upcomingVisit->getDayOfWeek(); ?></div>
                            <div><strong> at </strong><?php echo $upcomingVisit->getTime(); ?></div>
                        </div>
                    <?php };
                    ?>
                </div>
            </div>

            <div class="dasshboardTabItem">
                <h2>Edit Personal Information</h2>
                <form action="controllers/ClientController.php" method="post">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($person->getFirstName()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($person->getLastName()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($person->getPhoneNumber()); ?>" required>
                    </div>
                    <button type="submit" class="button">Update Information</button>
                </form>
            </div>

        </div>
    </div>
</main>

<?php include 'views/includes/footer.php'; ?>