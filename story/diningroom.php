<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Dining Room</title>
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
        $orderController->addToArrayAndOpen('kitchen');
    }elseif (isset($_POST['option2'])) {
        $orderController->addToArrayAndOpen('basement');
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
                <h1 class="card-title">The dining room</h1>
                <p class="card-text">The dining room can seat 30 guest. There is a large table in the
                     middle of the room. You can either [A] go to the kitchen, or [B] take the stairs to the basement.</p>

                <form method="POST">
                    <input type="hidden" name="option1" value="true">
                    <button type="submit" class="btn btn-danger">A: Go to the kitchen</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="option1" value="true">
                    <button type="submit" class="btn btn-danger">B: Go into the basement</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="undo" value="true">
                    <button type="submit" class="btn btn-info">Undo</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="saveStory" value="diningroom">
                    <button type="submit" class="btn btn-primary">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>