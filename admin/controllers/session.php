<?php
session_start();
if(!isset($_SESSION['name']) AND !isset($_SESSION['email']) AND !isset($_SESSION['id'])){
    header("location:login.html");
}
?>