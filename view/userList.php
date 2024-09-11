<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
</head>
<body>
<?php
require_once '../controller/userController.php';

$controller = new Controller();
$data = $controller->showData(); // Assuming showData() returns the data

foreach ($data as $item) {
    echo "<p>{$item['column_name']}</p>";
}
?>
</body>
</html>