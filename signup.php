<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../object/user.php';
 
$database = new database();
$db = $database->getConnection();
 
$user = new user($db);
 
// set user property values
$user->fname = $_POST['fname'];
$user->lname = $_POST['lname'];
$user->u_email = $_POST['u_email'];
$user->password = $_POST['password'];
$user->gender = $_POST['gender'];
$user->age = $_POST['age'];
$user->list_interest = $_POST['list_interest'];
$user->mob_number = $_POST['mob_number'];
$user->created = date('Y-m-d H:i:s');
 
// create the user
if($user->signup()){
    $user_arr=array(
        "status" => true,
        "message" => "Successfully Signup!",
        "u_email" => $user->u_email
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Username already exists!"
    );
}
print_r(json_encode($user_arr));
?>
