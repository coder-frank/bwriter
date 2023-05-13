<?php
if(isset($_POST['font'])){
    session_start();
    $userid = $_SESSION['id'];
    $fontS = $_POST['fontS'];
    $fontF = $_POST['fontF'];
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);

    if($scripts->changeFont($userid, "fontS", $fontS) == true AND $scripts->changeFont($userid, "fontF", $fontF) == true){
        echo("Font Setting Saved Successfully");
    } else {
         echo("Failed to Save Setting");
    }

}