<?php
session_start();
//add bill
$con = new mysqli("localhost", 'root', '', 'express');
$st_bill = $con->prepare("INSERT INTO bill(email) values(?)");
$st_bill->bind_param("s", $_SESSION["user"]);
$st_bill->execute();
//get bill no number //max(bill_no) last id in the given email
$st_billno = $con->prepare("SELECT max(bill_no) as billno FROM bill where email=?");
$st_billno->bind_param("s", $_SESSION["user"]);
$st_billno->execute();
$rs_billno = $st_billno->get_result();
$row_billno = $rs_billno->fetch_assoc();
$bno = $row_billno['billno'];
//add bill details  bill_det
$st_temp = $con->prepare("SELECT * FROM temp_order where email=?");
$st_temp->bind_param("s", $_SESSION["user"]);
$st_temp->execute();
$rs_temp = $st_temp->get_result();
while ($row_temp = $rs_temp->fetch_assoc()) {
    $st_billdet = $con->prepare("INSERT INTO bill_det values(?,?,?)");
    $st_billdet->bind_param("iii", $bno, $row_temp['itemid'], $row_temp['qty']);
    $st_billdet->execute();
}
//delete temp_order
    $st_del = $con->prepare("DELETE FROM temp_order WHERE email = ?");
    $st_del->bind_param("s", $_SESSION['user']);
    $st_del->execute();

    echo "<script>window.location = 'bill.php?bno=".$bno."';</script>";
