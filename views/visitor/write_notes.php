<?php
$headerTitle = "Nurse issue Note";
include 'views/includes/header.php'; ?>
<main>
    <h2>Write Visit Notes</h2>
    <form action="process_notes.php" method="post">
        <div class="form-group">
            <label for="visitId">Visit ID</label>
            <input type="text" id="visitId" name="visitId" required>
        </div>
        <div class="form-group">
            <label for="reportTitle">Report Title</label>
            <input type="text" id="reportTitle" name="reportTitle" required>
        </div>
        <div class="form-group">
            <label for="reportDescription">Report Description</label>
            <textarea id="reportDescription" name="reportDescription" required></textarea>
        </div>
        <button type="submit" class="button">Submit Note</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>