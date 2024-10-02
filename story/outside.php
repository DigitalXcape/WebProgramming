<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Outside</title>
</head>

<body class="bg-light">

<?php 

require_once '../controller/storyOrderController.php';
require_once '../controller/saveStoryController.php';

$orderController = new storyOrderController();
$saveController = new saveStoryController();

//Set Option Buttons
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['option1'])){
        $orderController->addToArrayAndOpen('foyer');        
    }elseif (isset($_POST['clearCookies'])) {
        $orderController->clearCookies();
    }elseif (isset($_POST['saveStory'])){
        $saveController->saveStoryProgress();    
    }
}

?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">This is outside of a haunted house</h1>
                <p class="card-text">You are about to step foot into a haunted house. Explore and make your choices! Warning: do NOT use the back arrows on the browser</p>

                <form method="POST">
                    <input type="hidden" name="option1" value="true">
                    <button type="submit" class="btn btn-success">Go inside the house</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="saveStory" value="outside">
                    <button type="submit" class="btn btn-primary">Save and Exit</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="clearCookies" value="true">
                    <button type="submit" class="btn btn-danger">Debug: Clear Cookies</button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>