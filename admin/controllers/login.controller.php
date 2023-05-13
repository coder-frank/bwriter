<?php
if (isset($_POST['login'])) {
    require_once '../config/db.php';
    require_once '../modals/all.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new All($db);
    $email = $_POST['email'];
    $pwd = $scripts->secure($_POST['password']);
    $loginUser = $scripts->login($email, $pwd);
    if ($loginUser == false) {
        echo "Inavlid Credentials Provided";
    } else {
         echo "Login Successful";
    }
    
    
}
