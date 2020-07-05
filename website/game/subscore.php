<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/user.php");
    exit;
}

require_once "../account/config.php";

$times = $_POST["times"];
$duration = $_POST["duration"];
$timestamp = $_POST["stime"];
$username = base64_encode($_SESSION["name"]);

$timestamp = date('Y-m-d H:i:s', $timestamp / 1000);

echo $timestamp." ".$times." ".$duration." ".$username;

$sql = "INSERT INTO score (name, timestamp, duration, times) VALUES (?, ?, ?, ?)";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "ssdi", $username, $timestamp, $duration, $times);
    if(mysqli_stmt_execute($stmt)){
        //finish
        http_response_code(200);
        header("HTTP/1.1 200 OK");
    }
}
mysqli_stmt_close($stmt);
