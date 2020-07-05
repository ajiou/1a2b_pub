<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // check username
    $sql = "SELECT id FROM account WHERE name = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        $param_username = base64_encode(trim($_POST["username"]));

        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                $username_err = "此名稱已被使用";
            } else {
                $username = trim($_POST["username"]);
            }
        }
    }
    mysqli_stmt_close($stmt);

    // check re enter password
    if ($password != $confirm_password){
        $confirm_password_err = "密碼不相符";
    }

    // insert
    if(empty($username_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO account (name, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // password + salt
            $pw_s = base64_encode(trim($_POST["password"])).$salt;
            $pw_s = hash("sha512", $pw_s);

            // Set var
            $param_username = base64_encode($username);
            $param_password = $pw_s;

            if(mysqli_stmt_execute($stmt)){
                //finish
                header("location: login.php?action=reg_success");
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/nav.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>
    <link rel="stylesheet" href="../styles/reg.css">

    <script rel="script" src="../scripts/reg.js"></script>

</head>
<body>
<!--navbar-->
<div class="topnav">
    <a href="../index.html">Home</a>
    <a id="reg" class="active" href="reg.php">註冊</a>
    <a id="login" href="login.php">登入</a>
</div>

<div class="main">
    <h1>註冊</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!--username-->
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="帳號" id="username" required>

        <!--pw-->
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="密碼" id="password" required onkeyup='check();'>

        <!--re-->
        <label for="repass">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="再次輸入" id="repass" required onkeyup='check();'>

        <span id='message' style="color: red;"><?php echo $username_err; ?><br><?php echo $confirm_password_err; ?></span>

        <input type="submit" id="submit" value="Sign Up">
    </form>
</div>
</body>
</html>
