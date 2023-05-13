<?php
if(isset($_POST['delete'])){
    $pid = $_POST['pid'];
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);
    $dPost = $scripts->deletePost($pid);
    $dComment = $scripts->deleteUniversal($pid);
    $dViews = $scripts->deleteViews($pid);
    if ($dPost == true AND $dComment == true AND $dViews == true) {
        echo("Article Deleted Successfully");
    } else {
         echo("Failed to Delete Article");
    }
}