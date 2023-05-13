<?php
if(isset($_POST['delete'])){
    $cid = $_POST['cid'];
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);
    $result = $scripts->deleteComment($cid);
    if ($result == true) {
        echo("Comment Deleted Successfully");
    } else {
         echo("Failed to Delete Comment");
    }
    
}