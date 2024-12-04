<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Applicant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Insert Applicant!</h1>
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="first_name">First Name</label> 
            <input type="text" name="first_name">
        </p>
        <p>
            <label for="last_name">Last Name</label> 
            <input type="text" name="last_name">
        </p>
        <p>
            <label for="email">Email</label> 
            <input type="text" name="email">
        </p>
        <p>
            <label for="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
        </p>
        <p>
            <label for="c_address">Home Address</label> 
            <input type="text" name="c_address">
        </p>
        <p>
            <label for="city">Location (City)</label> 
            <input type="text" name="city">
        </p>
        <p>
            <label for="nationality">Nationality</label> 
            <input type="text" name="nationality">
        </p>
        <p>
            <label for="years_of_experience">Years of Experience</label> 
            <input type="text" name="years_of_experience">
        </p>
        <br><br>
        <input type="submit" name="insertChefBtn">
    </form>
    <button onclick="window.location.href='index.php';">Back</button>
</body>
</html>
