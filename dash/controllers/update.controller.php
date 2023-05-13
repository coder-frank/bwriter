<?php
session_start();
if (isset($_POST['update_p']) AND isset($_SESSION['id'])) {
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);
    $id = $_POST['id'];
    $title = $_POST['title'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $body = $_POST['body'];

    $response = $scripts->updatePost($id, $category, $title, $author, $body, $status);
    if ($response == true) {
        echo "Article Updated Successfully";
    } else {
        echo "Something went wrong";
    }
}