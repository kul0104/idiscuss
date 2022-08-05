<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 100vh;
    }
    </style>

    <title> Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>

    <?php 
$id = $_GET['threadid'];
$sql = "SELECT * FROM `threads` WHERE threads_id=$id" ;
 $result = mysqli_query($conn, $sql);
 while($row = mysqli_fetch_assoc($result)){
    $title = $row['threads_title'];
    $desc = $row['threads_desc'];
    $thread_user_id = $row['threads_user_id'];

    //Query the users table to find out the name of original poster
    $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
   $posted_by = $row2['user_email'];
 
 }
?>

<?php
 $showAlert = false;
 $method = $_SERVER['REQUEST_METHOD'] ;
 if($method=='POST'){
     //insert into comment db
     $comment = $_POST['comment'];
     $comment = str_replace("<", "&lt", $comment);
     $comment = str_replace(">", "&gt", $comment);
     $sno = $_POST['sno'];
     $sql = "INSERT INTO `comments` (  `comment_content` , `thread_id` , `comment_by` , `comment_time` ) VALUES ( '$comment' , '$id' , '$sno' , current_timestamp())" ;
 $result = mysqli_query($conn, $sql);
 $showAlert = true;
 if($showAlert){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>Success</strong> Your Comment has been added  ! 
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
 }
 }
?>

    <!-- category container starts here -->
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title; ?> forums</h1>
            <p class="lead"><?php echo $desc; ?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum.No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Remain respectful of
                other members at all times.
            </p>
            <p>Posted By: <em><?php echo $posted_by?></em></p>
        </div>

    </div>


    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
   echo '<div class="container">
   <h1 class="py-2">Post a Comment</h1>
   <form action="' . $_SERVER["REQUEST_URI"]. '" method="post">
    <div class="form-group">
           <label for="exampleFormControlTextarea1">Type Your Comment</label>
           <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
           <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
       </div>
       <button type="submit" class="btn btn-success">Post Comment</button>
   </form>
</div>';
    }
    else{
      echo '<div class="container">
      <h1 class="py-2">Post a Comment</h1>
        <p>You are not logged in. Please login to Post a Comment</p>
    </div>';
 
    }
   ?>

    

    <div class="container" id="ques">
        <h1 class="py-2">Discussions</h1>


   <?php   
      $id = $_GET['threadid'];
       $sql = "SELECT * FROM `comments` WHERE thread_id=$id" ;
       $result = mysqli_query($conn, $sql);
       $noResult = true;
       while($row = mysqli_fetch_assoc($result)){  
        $noResult = false;
      $id = $row['comment_id'];
      $content = $row['comment_content'];
      $comment_time = $row['comment_time'];
      $thread_user_id= $row['comment_by'];
      $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_assoc($result2);
     
      echo '<div class="media my-3">
            <img src="user.png" width="30px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="fw-bold my-0">'. $row2['user_email'] . ' at '. $comment_time . '</p>
            '. $content . '
            </div>';
        }
        if ($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Comments found</p>
              <p class="lead"> Be the First person to comment"</p>
            </div>
          </div>';
        }
        ?> 
</div>

<?php include 'partials/_footer.php'; ?>



        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
        </script>



</body>

</html>