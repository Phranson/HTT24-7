<?php
$headerTitle = "Nurse Dashboard";
include 'views/includes/header.php'; ?>

<main>
    <div class="visitor-panel">
        <h2>Visitor Dashboard</h2>
        <div class="actions">
            <a href="view_schedule.php" class="button">View Schedule</a>
            <a href="write_notes.php" class="button">Write Visit Notes</a>
        </div>
    </div>
</main>

<?php include 'views/includes/footer.php'; ?>