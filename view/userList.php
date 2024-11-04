<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <script src="../library/FunctionLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php generateNavBar($navItems); ?>

<div class="container mt-5">
    <h1>Users</h1>
    <div id="userList" class="row font-weight-bold">
        <div class="col-4">Username</div>
        <div class="col-4">Email</div>
        <div class="col-4">Actions</div>
    </div>
    <hr>
    <div id="userData"></div> <!-- This will hold the user data fetched from the API -->
</div>

<script>
    // Function to fetch user data
    async function fetchUsers() {
        try {
            const response = await fetch('http://localhost/UserManagement/service/userManagementService.php?action=getUsers');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();

            // Build user list
            const userDataDiv = document.getElementById('userData');
            userDataDiv.innerHTML = ''; // Clear any existing content
            data.forEach(user => {
                userDataDiv.innerHTML += `
                    <div class="row">
                        <div class="col-4">${user.UserName}</div>
                        <div class="col-4">${user.Email}</div>
                        <div class="col-4">
                            <a href="userForm.php?UserID=${user.UserID}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="../controller/deleteUserController.php" method="POST" style="display:inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="userId" value="${user.UserID}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                    <hr>
                `;
            });
        } catch (error) {
            console.error('Error fetching users:', error);
            document.getElementById('userData').innerHTML = '<p class="text-danger">Failed to load user data.</p>';
        }
    }

    // Fetch users on page load
    document.addEventListener('DOMContentLoaded', fetchUsers);
</script>

</body>
</html>