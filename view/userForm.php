<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <script src="../library/FunctionLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php generateNavBar($navItems); ?>

    <?php
    require_once '../controller/UserController.php';

    $email = $username = $password = '';

    try {
        $controller = new UserController();

        $userID = null;
        if (isset($_GET['UserID'])) {
            $userID = $_GET['UserID'];
            echo "<p>User ID is: " . htmlspecialchars($userID) . "</p>";
        } else {
            throw new Exception("Getting ID failed (is it null?)");
        }

        if ($userID !== null && !empty($userID)) {
            $user = $controller->model->getUserById($userID);
            if ($user) {
                $email = $user->getEmail();
                $username = $user->getUsername();
                $password = $user->getPassword();
            } else {
                echo "<p>User not found.</p>";
            }
        } else {
            echo "<p>Invalid User ID.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
    ?>

    <div class="container mt-5">
        <h2>Edit User Form</h2>
        <form action="../controller/editUserController.php" method="POST">
            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userID); ?>">

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($password); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>