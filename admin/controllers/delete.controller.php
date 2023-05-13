<?php
if (isset($_POST['delete'])) {
    require_once '../config/db.php';
    require_once '../modals/all.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new All($db);
    $id = $_POST['id'];
    session_start();
    $email = $_SESSION['email'];
    $pwd = $scripts->secure($_POST['password']);
    if($scripts->verifyAdmin($email, $pwd) == true){
        $delete = $scripts->removeUser($id);
        if ($delete == false) {
            echo "Failed to delete user";
        } else {
             echo "User Deleted Successfully";
        }
    } else {
        echo "Sorry, Incorrect Password";
    }
   
    
    
}
