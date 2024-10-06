<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Foyer</title>
</head>

<body class="bg-light">

<?php 

require_once '../controller/storyOrderController.php';
require_once '../controller/saveStoryController.php';

$orderController = new storyOrderController();
$saveController = new saveStoryController();

// Set Option Buttons
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['option1'])) {
        $orderController->addToArrayAndOpen('upstairs');
    } elseif (isset($_POST['option2'])) {
        $orderController->addToArrayAndOpen('diningroom');
    } elseif (isset($_POST['option3'])) {
        $orderController->addToArrayAndOpen('parlor');
    } elseif (isset($_POST['undo'])) {
        $orderController->removeLastFromArrayAndOpen();
    }elseif (isset($_POST['saveStory'])){
        $saveController->saveStoryProgress();    
    }
}

?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Welcome to the Foyer</h1>
                <p class="card-text">You entered the foyer: a dim, dusty, cobweb filled hall with a stereotypical staircase going [A] upstairs. To the left is a [B] dining room, and to the right is a [C] parlor</p>

                <form method="POST">
                    <input type="hidden" name="option1" value="true">
                    <button type="submit" class="btn btn-danger">A: Go upstairs</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="option2" value="true">
                    <button type="submit" class="btn btn-warning">B: Go left into the dining room</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="option3" value="true">
                    <button type="submit" class="btn btn-success">C: Go right into the parlor</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="undo" value="true">
                    <button type="submit" class="btn btn-info">Undo</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="saveStory" value="foyer">
                    <button type="submit" class="btn btn-primary">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>