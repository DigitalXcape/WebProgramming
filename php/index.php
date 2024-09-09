<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="FunctionLibrary.js" defer></script>
    <?php include 'php/navbar.php'; ?>
</head>
<body>

    <div id="formContainer"></div>

    <?php generateNavBar($navItems); ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = FunctionLibrary.createForm('formContainer');

            const emailInput = FunctionLibrary.createEmailInput('useremail', 'Enter your email');

            FunctionLibrary.addFormField(form, emailInput);

            const phoneInput = FunctionLibrary.createPhoneNumberInput('userphone', "Phone Number");

            FunctionLibrary.addFormField(form, phoneInput)
        });
    </script>
</body>
</html>