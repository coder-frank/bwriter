<?php
session_start();
if (isset($_POST['change']) AND isset($_SESSION['id'])) {
    require_once '../config/db.php';
    require_once '../models/function.php';
    $db = new Database();
    $db = $db->connect();
    $scripts = new scripts($db);

    $id = $_SESSION['id'];
    $old = $_POST['old'];
    $new = $_POST['new'];

    $response = $scripts->changePwd($id, $old, $new);
    echo $response;
}