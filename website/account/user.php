<?php
session_start();

$ltimes = $lduration = $ltimestamp ="尚未遊玩";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$username = $_SESSION['name'];
$bname = base64_encode($_SESSION['name']);

require_once "config.php";

$sql = "select times from score where name = "."'".$bname."' order by times limit 1";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $ltimes = $row["times"];
    }
}

$sql = "select duration from score where name = "."'".$bname."' order by duration limit 1";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $lduration = $row["duration"];
    }
}

$sql = "select timestamp from score where name = "."'".$bname."' order by timestamp desc limit 1";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $ltimestamp = $row["timestamp"];
    }
}

?>

<!DOCTYPE html>
<html lang="zh_TW">
<head>
    <meta charset="utf-8">
    <title><?php echo $username; ?> -- 1a2b</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--    self-->
    <link rel="stylesheet" href="../styles/nav.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>
    <link rel="stylesheet" href="../styles/user.css">
</head>
<body>
    <!--navbar-->
    <div class="topnav">
        <a href="../index.html">Home</a>
        <a id="reg" href="logout.php">登出</a>
        <a id="login" class="active" href="login.php"><?php echo $username; ?></a>
    </div>
    <!--static-->
    <div class="static">
        <h1>遊玩</h1>
        <a href="../game/log_game.php" id="all" class="btn btn-primary" role="button">PLAY</a>
        <h1>統計</h1>
        最少次數:<?php echo $ltimes ?><br><br>最短時間:<?php echo $lduration ?><br><br>最後遊玩:<?php echo $ltimestamp ?>
        <a href="all.php" id="all" class="btn btn-primary" role="button">列出所有遊玩記錄</a>
    </div>
</body>
</html>