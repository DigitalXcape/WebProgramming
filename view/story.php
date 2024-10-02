<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Example</title>
    <script src="../library/FunctionLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php generateNavBar($navItems); ?>
    <div class="container mt-5">
        <h1 class="fs-5">Interactive Story Game</h1>
        <p class="lead">This is a stroy about going on a walk with multiple options.</p>
        <form action="../controller/openStoryController.php" method="POST">
            <button type="submit" class="btn btn-primary">Click this button to go on a walk.</button>
        </form>
    </div>
</body>
</html>