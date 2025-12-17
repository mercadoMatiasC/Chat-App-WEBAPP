<body style='background-color: black;'>
<?php 
    try{
        $base = New PDO ("mysql:host=localhost; dbname=chatapp", "root", "");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = htmlentities(addslashes($_POST['username']));
        $password = htmlentities(addslashes($_POST['password']));

        $sql = 'SELECT * FROM users WHERE username= :username AND userpassword= :userpassword';

        $result = $base->prepare($sql);
        $result->bindValue(':username', $username);
        $result->bindValue(':userpassword', $password);
        $result->execute(); 

        $register_number = $result->rowCount();

        if($register_number != 0){
            session_start();

            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];

            header("location:../index.php");
        }else{
            header("location:login.php");
        }

    }catch(exception $e){ 
        die("Error: ".$e->getMessage()."<br>In line: ".$e->getLine());
    }
?>
</body>