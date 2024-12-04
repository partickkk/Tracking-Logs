<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Chef</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Are you sure you want to delete this user?</h1>
    <?php $getChefByID = getChefByID($pdo, $_GET['id']); ?>
    <div class="container" style="border-style: solid; border-color: red; background-color: #ffcbd1;height: 500px;">
        <h2>First Name: <?php echo $getChefByID['first_name']; ?></h2>
        <h2>Last Name: <?php echo $getChefByID['last_name']; ?></h2>
        <h2>Email: <?php echo $getChefByID['email']; ?></h2>
        <h2>Gender: <?php echo $getChefByID['gender']; ?></h2>
        <h2>Home Address: <?php echo $getChefByID['c_address']; ?></h2>
        <h2>City: <?php echo $getChefByID['city']; ?></h2>
        <h2>Nationality: <?php echo $getChefByID['nationality']; ?></h2>
        <h2>Years of Experience: <?php echo $getChefByID['years_of_experience']; ?></h2>
        <div class="deleteBtn" style="float: right; margin-right: 10px;">
            <form action="core/handleForms.php?id=<?php echo $_GET['id']; ?>" method="POST">
                <input type="submit" name="deleteChefBtn" value="Delete" style="background-color: #f69697; border-style: solid;">
            </form>            
        </div>    
    </div>
</body>
</html>
