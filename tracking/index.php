<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; 
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chef Application</title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>

<?php include 'navbar.php'; ?>


	<?php if (isset($_SESSION['message'])) { ?>
		<h1 style="color: green; text-align: center; background-color: ghostwhite; border-style: solid;">	
			<?php echo $_SESSION['message']; ?>
		</h1>
	<?php } unset($_SESSION['message']); ?>


	<form class="searchQ" action="<?php echo ($_SERVER['PHP_SELF']);?>" method="GET">
		<input type="text" name="searchInput" placeholder="Search here">
		<input type="submit" name="searchBtn">
	</form>

	<p class="search"><a href="index.php">Clear Search Query</a></p>
	<table style="text-align: center;">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
            <th>Email</th>
			<th>Gender</th>
			<th>Address</th>
			<th>City</th>
            <th>Nationality</th>
			<th>Years of Experience</th>
			<th>Action</th>
		</tr>

		<?php if (!isset($_GET['searchBtn'])) { ?>
			<?php $getAllChefs = getAllChefs($pdo); ?>
				<?php foreach ($getAllChefs as $row) { ?>
					<tr>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['c_address']; ?></td>
						<td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['nationality']; ?></td>
						<td><?php echo $row['years_of_experience']; ?></td>
						<td>
							<a href="update.php?id=<?php echo $row['chef_id']; ?>">Edit</a>
							<a href="delete.php?id=<?php echo $row['chef_id']; ?>">Delete</a>
						</td>
					</tr>
			<?php } ?>
			
		<?php } else { ?>
			<?php $searchForChef = searchForChef($pdo, $_GET['searchInput']); ?>
				<?php foreach ($searchForChef as $row) { ?>
					<tr>
            			<td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['c_address']; ?></td>
						<td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['nationality']; ?></td>
						<td><?php echo $row['years_of_experience']; ?></td>
						<td>
							<a href="update.php?id=<?php echo $row['chef_id']; ?>">Edit</a>
							<a href="delete.php?id=<?php echo $row['chef_id']; ?>">Delete</a>
						</td>
					</tr>
				<?php } ?>
		<?php } ?>	
		
	</table>
</body>
</html>
