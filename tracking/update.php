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
    <title>Edit Chef</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php $getChefByID = getChefByID($pdo, $_GET['id']); ?>
    <h1>Edit the chef!</h1>
    <form action="core/handleForms.php?id=<?php echo $_GET['id']; ?>" method="POST">
    <p>
        <label for="first_name">First Name</label> 
        <input type="text" name="first_name" value="<?php echo $getChefByID['first_name']; ?>">
    </p>
    <p>
        <label for="last_name">Last Name</label> 
        <input type="text" name="last_name" value="<?php echo $getChefByID['last_name']; ?>">
    </p>

    <p>
        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
            <option value="Male" <?php echo ($getChefByID['gender'] == 'Male' ? 'selected' : ''); ?>>Male</option>
            <option value="Female" <?php echo ($getChefByID['gender'] == 'Female' ? 'selected' : ''); ?>>Female</option>
            <option value="Others" <?php echo ($getChefByID['gender'] == 'Others' ? 'selected' : ''); ?>>Others</option>
            <option value="Prefer not to say" <?php echo ($getChefByID['gender'] == 'Prefer not to say' ? 'selected' : ''); ?>>Prefer not to say</option>
        </select>
    </p>
    <p>
        <label for="email">Email</label> 
        <input type="text" name="email" value="<?php echo $getChefByID['email']; ?>">
    </p>
    <p>
        <label for="c_address">Home Address</label> 
        <input type="text" name="c_address" value="<?php echo $getChefByID['c_address']; ?>">
    </p>
    <p>
        <label for="city">Location</label> 
        <input type="text" name="city" value="<?php echo $getChefByID['city']; ?>">
    </p>
    <p>
        <label for="nationality">Nationality</label> 
        <input type="text" name="nationality" value="<?php echo $getChefByID['nationality']; ?>">
    </p>
    <p>
        <label for="years_of_experience">Years of Experience</label> 
        <input type="text" name="years_of_experience" value="<?php echo $getChefByID['years_of_experience']; ?>">
    </p>
    <br><br>
    <input type="submit" value="Save" name="editChefBtn">
    </form>
    <button onclick="window.location.href='index.php';">Back</button>
</body>
</html>
