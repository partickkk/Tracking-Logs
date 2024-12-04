<?php

require_once 'dbConfig.php';

function getAllChefs($pdo) {
    $sql = "SELECT * FROM chef_data 
            ORDER BY first_name ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getChefByID($pdo, $chef_id) {
    $sql = "SELECT * FROM chef_data WHERE chef_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$chef_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function searchForChef($pdo, $searchQuery) {
    $sql = "SELECT * FROM chef_data WHERE 
            BINARY CONCAT(first_name, last_name, nationality, gender, email, 
                          c_address, city, years_of_experience, date_added) 
            LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%" . $searchQuery . "%"]);

    return $stmt->fetchAll();
}

// Insert a new chef
function insertNewChef($pdo, $first_name, $last_name, $nationality, $gender, $email, 
                       $c_address, $city, $years_of_experience) {

    $response = array();
    $sql = "INSERT INTO chef_data 
            (
                first_name,
                last_name,
                nationality,
                gender,
                email,
                c_address,
                city,
                years_of_experience
            )
            VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        $first_name, $last_name, $nationality, $gender, $email, 
        $c_address, $city, $years_of_experience
    ]);

    if ($executeQuery) {
        $findInsertedItemSQL = "SELECT * FROM chef_data ORDER BY date_added DESC LIMIT 1";
        $stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
        $stmtfindInsertedItemSQL->execute();
        $getChefByID = $stmtfindInsertedItemSQL->fetch();

        $insertActivityLog = insertActivityLog($pdo, "INSERT", $getChefByID['chef_id'], 
            $getChefByID['first_name'], $getChefByID['last_name'], 
            $getChefByID['email'], $getChefByID['gender'], $getChefByID['c_address'], 
            $getChefByID['city'], $getChefByID['nationality'], $getChefByID['years_of_experience']);

        if ($insertActivityLog) {
            $response = array(
                "status" => "200",
                "message" => "Chef added successfully!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "Insertion of activity log failed!"
            );
        }

    } else {
        $response = array(
            "status" => "400",
            "message" => "Insertion of data failed!"
        );
    }

    return $response;
}

// Update a chef
function editChef($pdo, $first_name, $last_name, $nationality, $gender, $email, 
                  $c_address, $city, $years_of_experience, $chef_id) {
    $sql = "UPDATE chef_data SET first_name = ?, last_name = ?, nationality = ?, gender = ?, email = ?, 
            c_address = ?, city = ?, years_of_experience = ? WHERE chef_id = ?";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$first_name, $last_name, $nationality, $gender, $email, 
                           $c_address, $city, $years_of_experience, $chef_id]);
}

// Delete a chef
function deleteChef($pdo, $chef_id) { 
    $response = array();
    $sql = "SELECT * FROM chef_data WHERE chef_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$chef_id]);
    $getChefByID = $stmt->fetch();

    if ($getChefByID) {
        $deleteSql = "DELETE FROM chef_data WHERE chef_id = ?";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteQuery = $deleteStmt->execute([$chef_id]);

        if ($deleteQuery) {
            $insertActivityLog = insertActivityLog($pdo, "DELETE", $getChefByID['chef_id'], 
                $getChefByID['first_name'], $getChefByID['last_name'], 
                $getChefByID['email'], $getChefByID['gender'], $getChefByID['c_address'], 
                $getChefByID['city'], $getChefByID['nationality'], $getChefByID['years_of_experience']);

            $response = array(
                "status" => "200",
                "message" => "Deleted the chef successfully and activity log inserted!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "Failed to delete the chef!"
            );
        }
    } else {
        $response = array(
            "status" => "404",
            "message" => "Chef not found!"
        );
    }

    return $response;
}

// Check if user exists in user_accounts table
function checkIfUserExists($pdo, $username) {
    $response = array();
    $sql = "SELECT * FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {
        $userInfoArray = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            $response = array(
                "result" => true,
                "status" => "200",
                "userInfoArray" => $userInfoArray
            );
        } else {
            $response = array(
                "result" => false,
                "status" => "400",
                "message" => "User doesn't exist!"
            );
        }
    }

    return $response;
}

// Insert a new user into user_accounts table
function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
    $response = array();
    $checkIfUserExists = checkIfUserExists($pdo, $username);

    if (!$checkIfUserExists['result']) {
        $sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
                VALUES (?,?,?,?)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$username, $first_name, $last_name, $password])) {
            $response = array(
                "status" => "200",
                "message" => "User successfully inserted!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "An error occurred with the query!"
            );
        }
    } else {
        $response = array(
            "status" => "400",
            "message" => "User already exists!"
        );
    }

    return $response;
}

// Get all users from user_accounts table
function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_accounts";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

// Log activity
function insertActivityLog($pdo, $operation, $chef_id, $first_name, $last_name, $email, 
                             $gender, $c_address, $city, $nationality, $years_of_experience) {

    $sql = "INSERT INTO activity_logs (operation, chef_id, first_name, last_name, email, 
                                        gender, c_address, city, nationality, years_of_experience, date_added) 
            VALUES(?,?,?,?,?,?,?,?,?,?, NOW())";

    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([$operation, $chef_id, $first_name, $last_name, $email, 
                                    $gender, $c_address, $city, $nationality, $years_of_experience]);
    return $executeQuery;
}

function getAllActivityLogs($pdo) {
    $sql = "SELECT activity_log_id, operation, chef_id, first_name, last_name, email, gender, 
                   c_address, city, nationality, years_of_experience, date_added 
            FROM activity_logs";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        return $stmt->fetchAll();
    }
}


?>
