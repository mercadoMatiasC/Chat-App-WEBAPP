<?php 
    session_start();
    if(isset($_SESSION['username'])){
        echo "You´re already signed, ".$_SESSION['username']."!";
        echo "<br><a href='../index.php'>Go to Index</a>";
    }else{
?>
<!DOCTYPE html>
	<head>
 		<meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1">
  		<title>ChatApp - Register</title>
		<link rel="stylesheet" href="..\css\login.css">
	</head>
    <body>
        <div class="login-box" style="height: 580px;">
            <form action="registerAction.php" method="POST" enctype="multipart/form-data">
                <img id="icon" src="..\imgs\icons\pinku-blushed.png">

                <h1>Register</h1>

                <label for="name">Name</label>  
                <input type="text" name="name" required>
                
                <label for="surname">Surname</label>  
                <input type="text" name="surname" required>

                <br>
                <label for="male">Male</label>
                <input type="radio" name="sex" value="M" required>
				<label for="female">Female</label>
                <input type="radio" name="sex" value="F" required>
                
                <br>
                <label for="username">Username</label>  
                <input type="text" name="username" required>
                
                <label for="password">Password</label>  
                <input type="password" name="password" required>

                <label for="profile-pic">Profile picture</label>  
                <input type="file" name="upload" required/></input>

                <input type="SUBMIT" value="Register">
                <a class="link" href="login.php">
                    Already in?, Log in
                </a>
            </form>
        </div>
    </body>
</html>
<?php } ?>