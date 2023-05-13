<?php
session_start();
if (isset($_POST['create_p']) AND isset($_SESSION['id'])) {
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);
    $id = $_SESSION['id'];
    $title = $_POST['title'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $body = $_POST['body'];

    $response = $scripts->createPost($id, $category, $title, $author, $body, $status);
    if ($response == true) {
        if ($status == "draft") {
            echo "Post saved as draft";
        } else {
            echo "Post Created Successfully";
        }
        
    } else {
        echo "Something went wrong";
    }
}