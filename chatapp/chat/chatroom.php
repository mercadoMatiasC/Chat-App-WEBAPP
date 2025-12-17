<?php   
    include 'header.php';
    include '../connection.php';

    session_start();
    if(!isset($_SESSION['username'])){
        header('Location:../login/login.php');
    }else{
        if($_GET){
            $query = "SELECT * FROM users WHERE username = '".$_GET['chosenContact']."'";
            $response = mysqli_query(Connect(), $query);

            $currentContact = mysqli_fetch_array($response);

            $query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
            $response = mysqli_query(Connect(), $query);

            $currentUser = mysqli_fetch_array($response);
        }    
        if(!isset($currentContact)){
            header('location: ../index.php');
        }
?>

<div class="container">
    <div class="row" id="center-title">
        <div class="col-lg-4" id="left-username">
            <?php 
                $query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
                $response = mysqli_query(Connect(), $query);

                $currentUser = mysqli_fetch_array($response);

                echo "<img id='right-profile-pic' src='../uploads/user".$currentUser['id_user']."/profile.jpg'>" 
                .$currentUser['username'];
            ?> 
            <a href="../login/login.php">    
                <i id="logout-icon" class="fa fa-share" style="color: white;"></i>
            </a>
        </div>
        <div class="col-lg-8" id="contact-details">
            <h2 style="margin-top: 14px;"> 
                <a id="leave-chat" href="../index.php">    
                    <i class="fa fa-arrow-left" style="color: white;"></i>
                </a>
                <?php 
                    echo "<img id='right-profile-pic' style='margin-top: -15px;width: 50px; height: 50px;' src='../uploads/user".$currentContact['id_user']."/profile.jpg'>";               
                    echo $currentContact['username']; 
                ?> 
            </h2>
        </div>
    </div>
    <div class="row" id="center-content">
        <div class="col-lg-4" id="left-list">
            <?php    
                $query = "SELECT * FROM users WHERE username != '".$_SESSION['username']."' AND username != '".$currentContact['username']."'";
                $response = mysqli_query(Connect(), $query);

                foreach($response as $contact){
                    echo "<div id='contact'>
                            <form action='chatroom.php' method='GET'>
                                <img id='profile_pic_list' src='../uploads/user".$contact['id_user']."/profile.jpg'> &nbsp"
                                .$contact['username']."
                                <button class='btn btn-warning' id='chat-submit' type='submit' name='chosenContact' value='".$contact['username']."'>Chat</button>
                            </form>
                          </div>";
                }
            ?>
        </div>
        <div class="col-lg-8" id="right-content">
            <?php    
                $query = "SELECT * FROM messages WHERE 
                (id_fromuser = '".$currentUser['id_user']."' AND id_touser = '".$currentContact['id_user']."') OR 
                (id_fromuser = '".$currentContact['id_user']."' AND id_touser = '".$currentUser['id_user']."') ORDER BY sentdate ASC";
                
                $response = mysqli_query(Connect(), $query);
                
                foreach($response as $eachMessage){
                    if($eachMessage['id_fromuser'] == $currentUser['id_user']){
                        echo "<div id='yourmessage'>
                                ".$eachMessage['message']."
                                <div id='sent-at'>
                                    ".$start_time = date("h:i A", strtotime($eachMessage['sentdate'])).
                                "</div>
                            </div>";
                    }else{
                        echo "<div id='mymessage'>
                                ".$eachMessage['message']."
                                <div id='sent-at'>
                                    ".$start_time = date("h:i A", strtotime($eachMessage['sentdate'])).
                                "</div>
                            </div>";
                    }
                }
            ?>
        </div>
        <script>
            var textarea = document.getElementById('right-content');
            textarea.scrollTop = textarea.scrollHeight;
        </script>
    </div>
    <div class='row' id='message-box'>
        <div class="col-lg-4">
        </div> 
        <div class="col-lg-8" style='background-color: black; height: 55px;'>
            <form action="sendMessage.php" method='POST'>
                <input type="text" id='message-field' name='message' placeholder='  Send a message!...'></input>
                <button id='submit-message' type='submit' name='currentContact' value='<?php echo $currentContact['id_user'];?>' class='btn btn-purple'>
                    <i class='fa fa-check'></i>
                </button>
            </form>
        </div> 
    </div>
</div>

<?php
    include 'footer.php';
}?>

