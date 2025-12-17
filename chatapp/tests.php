<body style='background-color: black; color:white;'>
<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location:login/login.php');
    }else{
        include_once 'connection.php';

        //DEFINE CURRENT USER
        $query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
        $response = mysqli_query(Connect(), $query);    
        foreach($response as $user){
            $currentUserID = $user['id_user'];
        }

        if($currentUserID > 0){
            echo "You're not allowed in here!";
        }
        //IF ITS ADMIN!
        else{

            //DEFINE CURRENT CONTACT
            $query = "SELECT * FROM users WHERE id_user = '".$_POST['currentContact']."'";
            $response = mysqli_query(Connect(), $query);    
            foreach($response as $contact){
                $currentContactUsername = $contact['username'];
            }

            try{
                //CONNECTION
                $base = New PDO ("mysql:host=localhost; dbname=chatapp", "root", "");
                $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                $message = htmlentities(addslashes($_POST['message']));
                $currentContact = htmlentities(addslashes($_POST['currentContact']));
        
                //QUERY
                $sql = 'INSERT INTO messages VALUES(
                    null, :from, :to ,:message, DEFAULT 
                );';

                //BIND VALUES
                $result = $base->prepare($sql);
                $result->bindValue(':from', $currentUserID);
                $result->bindValue(':to', $_POST['currentContact']);
                $result->bindValue(':message', $message);
                
                //RUN
                $result->execute();
            }catch(exception $e){ 
                die("Error: ".$e->getMessage()."<br>In line: ".$e->getLine());
            }
        }
    }
?>
</body>