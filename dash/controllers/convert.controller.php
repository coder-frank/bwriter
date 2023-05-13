<?php
if(isset($_POST['convert'])){
    $status = strtolower($_POST['convert']);
    $pid = $_POST['pid'];
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);
    $result = $scripts->changeStatus($status, $pid);
    if ($result == true) {
        echo("Status Changed Successfully");
    } else {
         echo("Failed to Change Status");
    }
    
}