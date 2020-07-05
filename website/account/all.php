<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/login.php");
    exit;
}

$name = base64_encode($_SESSION["name"]);

require_once "config.php";

$sql = "select timestamp, duration, times from score where name = "."'".$name."' order by timestamp desc";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "遊玩時間: " . $row["timestamp"]. " 花費秒數: " . $row["duration"]. " 花費次數: " . $row["times"]. "<br>";
    }
} else {
    echo "尚未遊玩";
}