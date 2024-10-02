<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Test</title>
    <script src="../library/FunctionLibrary.js" defer></script>
    <?php include '../php/navbar.php'; ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Navigation Bar (with Bootstrap classes) -->
    <?php generateNavBar($navItems); ?>

    <div class="container my-5">
        <div id="formContainer" class="p-4 border rounded bg-light"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = FunctionLibrary.createForm('formContainer');
            form.classList.add('form-group'); // Add Bootstrap class to the form container

            const emailInput = FunctionLibrary.createEmailInput('useremail', 'Enter your email');
            emailInput.classList.add('form-control', 'mb-3'); // Add Bootstrap classes to email input
            FunctionLibrary.addFormField(form, emailInput);

            const phoneInput = FunctionLibrary.createPhoneNumberInput('userphone', 'Phone Number');
            phoneInput.classList.add('form-control', 'mb-3'); // Add Bootstrap classes to phone input
            FunctionLibrary.addFormField(form, phoneInput);

            const radialButtonTest = FunctionLibrary.createRadialButtons('genderselect', ['Male', 'Female']);
            FunctionLibrary.addFormField(form, radialButtonTest);

            const submitButton = FunctionLibrary.createSubmitButton('Submit Form!', "");
            submitButton.classList.add('btn', 'btn-primary');
            FunctionLibrary.addFormField(form, submitButton);

            form.addEventListener('submit', function(event) {
                event.preventDefault();
              });
        });
    </script>
</body>
</html>