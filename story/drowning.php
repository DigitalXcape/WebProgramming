<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>You Died!</title>
</head>

<body class="bg-light">

<?php 

require_once '../controller/storyOrderController.php';
require_once '../controller/saveStoryController.php';

$orderController = new storyOrderController();
$saveController = new saveStoryController();

// Set Option Buttons
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['undo'])) {
        $orderController->removeLastFromArrayAndOpen();
    }elseif (isset($_POST['saveStory'])){
        $saveController->saveStoryProgress();    
    }
}

?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Ending 2: Death</h1>
                <p class="card-text">Unsuprisingly, the century old wood collapses and you fall in. 
                    For the sake of the plot you cant swim in water that is probably only 3 feet deep because its on the edge of a lake. Thus, you drowned...<br>
                    This ending has 1 route.</p>

                <form method="POST">
                    <input type="hidden" name="undo" value="true">
                    <button type="submit" class="btn btn-info">Undo</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="saveStory" value="drowning">
                    <button type="submit" class="btn btn-primary">Save and Exit</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>