<!DOCTYPE html>
<html>
	<head>
 		<meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1">
  		<title>ChatApp - Log In</title>
		<link rel="stylesheet" href="..\css\login.css">
	</head>
    <body>
        <?php 
            session_start();
            session_destroy();
        ?>
        <div class="login-box">
            <form action="loginAction.php" method="POST">
                <img id="icon" src="..\imgs\icons\pinku-default.png">

                <h1>Log In</h1>

                <label for="username">Username</label>  
                <input type="text" name="username" required>
                
                <label for="password">Password</label>  
                <input type="password" name="password" required>

                <input type="SUBMIT" value="Send">
                <a class="link" href="register.php">
                New here?, Register
                </a>
            </form>
        </div>
    </body>
</html>
