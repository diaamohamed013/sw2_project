<?php

// include database and object files
include_once '../config/database.php';
include_once '../object/user.php';
 
// get database connection
$database = new database();
$db = $database->getConnection();
 
// prepare user object
$user = new user($db);

// set ID property of user to be edited
$user->u_email = isset($_GET['u_email']) ? $_GET['u_email'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();

// read the details of user to be edited
$stmt = $user->login();

if($stmt->rowCount() > 0){

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // create array
    $user_arr=array(
        "status" => true,
        "message" => "Successfully Login!",
        "u_email" => $row['u_email']
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Invalid Username or Password!",
    );
}

// make it json format
print_r(json_encode($user_arr));
?>
