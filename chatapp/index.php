<?php   
    include 'header.php';
    include 'connection.php';

    session_start();
    if(!isset($_SESSION['username'])){
        header('Location:login/login.php');
    }else{
?>

<div class="container">
    <div class="row" id="center-title">
        <div class="col-lg-4" id="left-username">
            <?php 
                $query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
                $response = mysqli_query(Connect(), $query);

                $currentUser = mysqli_fetch_array($response);

                echo "<img id='right-profile-pic' src='uploads/user".$currentUser['id_user']."/profile.jpg'>" 
                .$currentUser['username'];
            ?> 
            <a href="login/login.php">    
                <i id="logout-icon" class="fa fa-share" style="color: white;"></i>
            </a>
        </div>
        <div class="col-lg-8" id="contact-details">
            <h2 style="margin-top: 14px;"> Welcome! </h2>
        </div>
    </div>
    <div class="row" id="center-content">
        <div class="col-lg-4" id="left-list">
            <?php    
                $query = "SELECT * FROM users WHERE username != '".$_SESSION['username']."'";
                $response = mysqli_query(Connect(), $query);

                if (!$response)
                    die("Query Failed.");

                foreach($response as $contact){
                    echo "<div id='contact'>
                            <form action='chat/chatroom.php' method='GET'>
                                <img id='profile_pic_list' src='uploads/user".$contact['id_user']."/profile.jpg'> &nbsp"
                                .$contact['username']."
                                <button class='btn btn-warning' id='chat-submit' type='submit' name='chosenContact' value='".$contact['username']."'>Chat</button>
                            </form>
                          </div>";
                }
            ?>
        </div>
        <div class="col-lg-8" id="right-content">
            <center id="chatbox">
                Select a contact to start chatting!
            </center>
        </div>
    </div>
</div>

<?php
    include 'footer.php';
}?>

