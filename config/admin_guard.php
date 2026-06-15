<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../auth/login.php");
    exit;
}
