<?php  

require_once 'dbConfig.php';
require_once 'models.php';

// Insert new chef
if (isset($_POST['insertChefBtn'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $c_address = trim($_POST['c_address']);
    $city = trim($_POST['city']);
    $nationality = trim($_POST['nationality']);
    $years_of_experience = trim($_POST['years_of_experience']);

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender)
        && !empty($c_address) && !empty($city) && !empty($nationality) && !empty($years_of_experience)) {

        $insertChef = insertNewChef($pdo, $first_name, $last_name, $email, $gender, 
                                    $c_address, $city, $nationality, $years_of_experience);

        $_SESSION['status'] = $insertChef['status']; 
        $_SESSION['message'] = $insertChef['message']; 
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../index.php");
        exit;
    }
}

// Edit chef
if (isset($_POST['editChefBtn'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $c_address = trim($_POST['c_address']);
    $city = trim($_POST['city']);
    $nationality = trim($_POST['nationality']);
    $years_of_experience = trim($_POST['years_of_experience']);
    $chef_id = $_GET['chef_id'];

    $updateResult = editChef($pdo, $first_name, $last_name, $email, $gender, $c_address, $city, 
                            $nationality, $years_of_experience, $chef_id);

    if ($updateResult) {
        $operation = "UPDATED";
        insertActivityLog($pdo, $operation, $chef_id, $first_name, $last_name, $email, 
                          $gender, $c_address, $city, $nationality, $years_of_experience);

        $_SESSION['message'] = "Chef updated successfully!";
        $_SESSION['status'] = "success";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['message'] = "Failed to update chef!";
        $_SESSION['status'] = "error";
        header("Location: edit.php?chef_id=" . $chef_id);
        exit;
    }
}

// Delete chef
if (isset($_POST['deleteChefBtn'])) {
    $id = $_GET['id'];

    if (!empty($id)) {
        $deleteChef = deleteChef($pdo, $id);
        $_SESSION['message'] = $deleteChef['message'];
        $_SESSION['status'] = $deleteChef['status'];
        header("Location: ../index.php");
    }
}

// Search chef
if (isset($_GET['searchBtn'])) {
    $searchForChef = searchForChef($pdo, $_GET['searchInput']);
    foreach ($searchForChef as $row) {
        echo "<tr> 
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['c_address']}</td>
                <td>{$row['city']}</td>
                <td>{$row['nationality']}</td>
                <td>{$row['years_of_experience']}</td>
              </tr>";
    }
}

// Insert new user
if (isset($_POST['insertNewUserBtn'])) {
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($first_name) && !empty($last_name) && 
        !empty($password) && !empty($confirm_password)) {

        if ($password == $confirm_password) {
            $insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, 
                                         password_hash($password, PASSWORD_DEFAULT));

            if ($insertQuery['status'] == '200') {
                $_SESSION['message'] = $insertQuery['message'];
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../login.php");
            } else {
                $_SESSION['message'] = $insertQuery['message'];
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../register.php");
            }
        } else {
            $_SESSION['message'] = "Please make sure both passwords are equal";
            $_SESSION['status'] = "400";
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = "400";
        header("Location: ../register.php");
    }
}

// Login user
if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $loginQuery = checkIfUserExists($pdo, $username);

        if ($loginQuery['status'] == '200') {
            $usernameFromDB = $loginQuery['userInfoArray']['username'];
            $passwordFromDB = $loginQuery['userInfoArray']['password'];

            if (password_verify($password, $passwordFromDB)) {
                $_SESSION['username'] = $usernameFromDB;
                header("Location: ../index.php");
            }
        } else {
            $_SESSION['message'] = $loginQuery['message'];
            $_SESSION['status'] = $loginQuery['status'];
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure no input fields are empty";
        $_SESSION['status'] = "400";
        header("Location: ../login.php");
        exit;
    }
}

// Logout user
if (isset($_GET['logoutUserBtn'])) {
    unset($_SESSION['username']);
    header("Location: ../login.php");
    exit;
}
?>
