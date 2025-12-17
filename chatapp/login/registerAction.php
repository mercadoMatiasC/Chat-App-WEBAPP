<body style='background-color: black; color: white;'>
<?php 
    if(!isset($_FILES)){
        echo "No files uploaded! :/";
    }

    try{
        $base = New PDO ("mysql:host=localhost; dbname=chatapp", "root", "");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = htmlentities(addslashes($_POST['username']));
        $sql = 'SELECT * FROM users WHERE username= :username';

        $result = $base->prepare($sql);
        $result->bindValue(':username', $username);

        $result->execute();

        $register_number = $result->rowCount();

        if($register_number != 0){
            echo "This username already exists!";
            echo "<br><a href='register.php'>Register form</a> | 
                      <a href='login.php'>Log in form</a>";
        }else{
            $name = htmlentities(addslashes($_POST['name']));
            $surname = htmlentities(addslashes($_POST['surname']));
            $sex = htmlentities(addslashes($_POST['sex']));
            $password = htmlentities(addslashes($_POST['password']));

            $sql = "INSERT INTO users VALUES (null, 1, :name, :surname, :sex, 'Hey, Im using ProtoChat', :username, :userpassword)";
            
            $result = $base->prepare($sql);
            $result->bindValue(':name', $name);
            $result->bindValue(':surname', $surname);
            $result->bindValue(':sex', $sex);
            $result->bindValue(':username', $username);
            $result->bindValue(':userpassword', $password);

            $uploaded = $_FILES['upload'];

            if ($uploaded["error"] > 0){
                echo "Error: ".$uploaded['error'];
            }
            else{
                $filename = $uploaded["name"];
                $tempname = $uploaded["tmp_name"];   

                echo "<br>Name: ".$name;
                echo "<br>Surname: ".$surname;
                echo "<br>Username: ".$username;
                echo "<br>Sex: ".$sex;
                echo "<br>Password: ".$password;
                echo "<br>".$sql;

                $result->execute(); 

                include_once '../connection.php';

                $query = "SELECT * FROM users WHERE username = '".$username."'";
                $response = mysqli_query(Connect(), $query);

                $newUser = mysqli_fetch_array($response);

                $dir = "../uploads/user".$newUser['id_user'];
                
                if (!is_file($dir) && !is_dir($dir)){
                    mkdir($dir);
                }

                move_uploaded_file($tempname, $dir."/profile.jpg");

                header("location:login.php");
            }     
        }

    }catch(exception $e){ 
        die("Error: ".$e->getMessage()."<br>In line: ".$e->getLine());
    }
?>
</body>