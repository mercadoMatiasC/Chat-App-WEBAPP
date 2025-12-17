<body style='background-color: black; color:white;'>
<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location:../login/login.php');
    }else{
         //DEFINE CURRENT CONTACT
        include_once '../connection.php';
        $query = "SELECT * FROM users WHERE id_user = '".$_POST['currentContact']."'";
        $response = mysqli_query(Connect(), $query);    
        foreach($response as $contact){
            $currentContactUsername = $contact['username'];
        }
        if($_POST['message'] == ""){
            header('location: chatroom.php?chosenContact='.$currentContactUsername.'');
        }
        else{
            echo $_POST['message'];
            echo $_POST['currentContact'];
        try{
            $base = New PDO ("mysql:host=localhost; dbname=chatapp", "root", "");
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $message = htmlentities(addslashes($_POST['message']));
            $currentContact = htmlentities(addslashes($_POST['currentContact']));

            $sql = 'INSERT INTO messages VALUES(
                null, :from, :to ,:message, DEFAULT 
            );';

            //DEFINE CURRENT USER
            $query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
            $response = mysqli_query(Connect(), $query);    
            foreach($response as $user){
                $currentUserID = $user['id_user'];
            }

            $result = $base->prepare($sql);
            $result->bindValue(':from', $currentUserID);
            $result->bindValue(':to', $_POST['currentContact']);
            $result->bindValue(':message', $message);

            $result->execute();

            header('location: chatroom.php?chosenContact='.$currentContactUsername.'');
        }catch(exception $e){ 
        die("Error: ".$e->getMessage()."<br>In line: ".$e->getLine());
        }
    }
}
?>
</body>