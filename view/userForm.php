<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <script src="../library/FunctionLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <form>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" value="<?php echo $password; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>