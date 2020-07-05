<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/login.php");
    exit;
}

$username = $_SESSION['name']

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1A2B Guess Number</title>
    <link rel="stylesheet" href="../styles/acc_game.css">
    <link rel="stylesheet" href="../styles/nav.css">

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>

<body>
<!--overlay-->
<div id="overlay">
    <button id="close" type="button" class="btn btn-primary" onclick="off()">點擊以開始遊戲</button>
</div>

<!--navbar-->
<div class="topnav">
    <a href="../index.html">Home</a>
    <a id="reg" href="../account/logout.php">登出</a>
    <a id="login" href="../account/user.php"><?php echo $username; ?></a>
</div>

<!--main-->
<div id="main">
    <label>
        <input type="text" id="input" placeholder="輸入答案"/>
    </label>
    <button type=submit class="btn btn-primary" id="submit" onclick="check()">送出</button>
    <div id="msg"></div>
    <textarea id="history" name="w3review" rows="10" cols="25" readonly disabled></textarea>
</div>

<!-- Bootstrap modal popup end game -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">遊戲結束</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                答案 : <span id="ans"></span><br><br>
                時間 : <span id="duration"></span><br>
                次數 : <span id="time"></span>
                <br><br>恭喜
            </div>
            <div class="modal-footer">
                <button type="button" id="end" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/log_game.js"></script>
</body>
</html>
