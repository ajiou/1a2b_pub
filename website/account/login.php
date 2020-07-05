<?php
session_start();

$success = "";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: user.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = base64_encode(trim($_POST["username"]));
    $password = trim($_POST["password"]);

    // check
    if ($stmt = $link->prepare('SELECT id, password FROM account WHERE name = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        //check
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            // account exist check pw
            if (hash("sha512", base64_encode($_POST["password"]).$salt) == $password) {
                // success
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;

                $success = "登入成功";
                header( "refresh:2; url=user.php" );
            } else {
                //pw wrong
                $password_err = "密碼錯誤!!";
            }
        } else {
            //account wrong
            $username_err = "帳號錯誤!!";
        }

        $stmt->close();
    }
}
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="zh_TW">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!--    self-->
    <link rel="stylesheet" href="../styles/nav.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>

    <!--navbar-->
    <div class="topnav">
        <a href="../index.html">Home</a>
        <a id="reg" href="reg.php">註冊</a>
        <a id="login" class="active" href="login.php">登入</a>
    </div>

    <script src="../scripts/login.js" type="application/javascript"></script>

    <div class="login">
        <h1>登入</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="username">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" name="username" placeholder="帳號" id="username" required>

                    <label for="password">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" name="password" placeholder="密碼" id="password" required>

                    <span id='message' style="color: red;"><?php echo $username_err; ?><br><?php echo $password_err; ?></span>
                    <span id="success" style="color: #4CAF50;"><?php echo $success; ?></span>
                    <input type="submit" value="Login">
            </form>
    </div>

</body>
</html>