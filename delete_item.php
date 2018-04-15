<?php
session_start();
$con = new mysqli("localhost", 'root', '', 'express');
$st_check = $con->prepare("DELETE FROM temp_order WHERE email = ? and itemid = ?");
$st_check->bind_param("si", $_SESSION["user"], $_GET["id"]);//i integer
$st_check->execute();

echo "<script>window.location='menu.php';</script>";
