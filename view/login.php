<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <script src="../library/VerificationLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php generateNavBar($navItems); ?>    
<div class="container mt-5">

    <h2>Log In</h2>
    <form action="../controller/loginController.php" method="POST">

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" id="password" name="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
</div>
</body>
</html>