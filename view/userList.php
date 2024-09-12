<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <script src="../library/FunctionLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php generateNavBar($navItems); ?>

<?php
require_once '../controller/userController.php';

$controller = new UserController();
$data = $controller->showData();
?>

<div class="container mt-5">
    <h1>Users</h1>
    <div class="row font-weight-bold">
        <div class="col-4">Username</div>
        <div class="col-4">Password</div>
        <div class="col-4">Actions</div>
    </div>
    <hr>
    <?php foreach ($data as $item): ?>
        <div class="row">
            <div class="col-4"><?php echo htmlspecialchars($item['UserName']); ?></div>
            <div class="col-4"><?php echo htmlspecialchars($item['Password']); ?></div>
            <div class="col-4">
                <a href="userForm.php?UserID=<?php echo urlencode($item['UserID']); ?>" class="btn btn-primary btn-sm">Edit</a>
                
                <form action="../controller/deleteUserController.php" method="POST" style="display:inline;">
                    <input type="hidden" name="UserID" value="<?php echo htmlspecialchars($item['UserID']); ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>