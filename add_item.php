<?php //this page will not appear to the user
session_start();
$con = new mysqli("localhost", 'root', '', 'express');
$st_check = $con->prepare("SELECT * FROM temp_order WHERE email = ? and itemid = ?");
$st_check->bind_param("si", $_SESSION["user"], $_GET["id"]);//i integer
$st_check->execute();
$rs = $st_check->get_result();
if ($rs->num_rows==0) {
    $st = $con->prepare("INSERT INTO temp_order(email,itemid) values(?,?)");
    $st->bind_param("si", $_SESSION["user"], $_GET["id"]);//i integer
    $st->execute();
} else {
    $st = $con->prepare("UPDATE temp_order SET qty=qty+1 WHERE email=?");
    $st->bind_param("s", $_SESSION["user"]);
    $st->execute();
}


