<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php generateNavBar($navItems); ?>

<div class="container mt-5">
    <h1>Users</h1>
    <div id="userList" class="row font-weight-bold">
        <div class="col-3">Username</div>
        <div class="col-3">Email</div>
        <div class="col-3">Current Story Page</div>
        <div class="col-3">Actions</div>
    </div>
    <hr>

    <?php
    require_once '../logger/Logger.php';
    $logger = Logger::getInstance();

    // Log the beginning of the user list retrieval
    $logger->log("Fetching user list...");

    // API URL for fetching users
    $apiUrl = 'http://localhost/UserManagementAPI/controller/getUsers.php';
    $logger->log("API URL: " . $apiUrl); // Log the API URL

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Execute cURL request
    $apiResponse = curl_exec($ch);

    // Log the cURL execution result
    if (curl_errno($ch)) {
        $logger->log("CURL error: " . curl_error($ch));
        echo "<div class='text-danger'>Failed to retrieve user list</div>";
    } else {
        $logger->log("CURL executed successfully.");

        // Log the raw API response
        $logger->log("API Response: " . print_r($apiResponse, true));

        // Attempt to decode JSON response
        $data = json_decode($apiResponse, true);
        
        // Check if json_decode was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            $logger->log("JSON decode error: " . json_last_error_msg());
            echo "<div class='text-danger'>Failed to decode JSON response: " . json_last_error_msg() . "</div>";
        } elseif (is_array($data) && isset($data['success']) && $data['success']) {
            if (!empty($data['users'])) {

                foreach ($data['users'] as $user) {
                    echo "<div class='row mb-2'>";
                    echo "<div class='col-3'>" . htmlspecialchars($user['username']) . "</div>";
                    echo "<div class='col-3'>" . htmlspecialchars($user['email']) . "</div>";
                    echo "<div class='col-3'>" . htmlspecialchars($user['story_page']) . "</div>";
                    echo "<div class='col-3'>";
                
                    echo "<form action='../controller/deleteUserController.php' method='POST' style='display:inline;'>";
                    echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user['user_id']) . "' />";
                    echo "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>";
                    echo "</form>";
                
                    echo "</div>";
                    echo "</div>";
                }
                $logger->log("User list successfully retrieved with " . count($data['users']) . " users.");
            } else {
                echo "<div class='text-warning'>No users found</div>";
                $logger->log("No users found in the database.");
            }
        } else {
            $message = is_array($data) && isset($data['message']) ? $data['message'] : 'Unknown error occurred';
            echo "<div class='text-danger'>" . htmlspecialchars($message) . "</div>";
            $logger->log("Error retrieving users: " . htmlspecialchars($message));
        }
    }

    curl_close($ch);

    // Log the end of the user list retrieval
    $logger->log("Finished fetching user list.");
    ?>
</div>

</body>
</html>