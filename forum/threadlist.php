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
        min-height: 435px;
    }
    </style>

    <title> Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php 
$id = $_GET['catid'];
$sql = "SELECT * FROM `categories` WHERE category_id=$id" ;
 $result = mysqli_query($conn, $sql);
 while($row = mysqli_fetch_assoc($result)){
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
 }
?>

    <?php
 $showAlert = false;
 $method = $_SERVER['REQUEST_METHOD'] ;
 if($method=="POST"){
     $th_title = $_POST['title'];
     $th_desc = $_POST['desc'];

     $th_title = str_replace("<", "&lt", $th_title);
     $th_title = str_replace(">", "&gt", $th_title);

     $th_desc = str_replace("<", "&lt", $th_desc);
     $th_desc = str_replace(">", "&gt", $th_desc);


     $sno = $_POST['sno'];
     $sql = "INSERT INTO `threads` (`threads_title`, `threads_desc`, `threads_cat_id`, `threads_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())" ;
 $result = mysqli_query($conn, $sql);
 $showAlert = true;
 if($showAlert){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>Success</strong> Your thread has been added successfully ! Please wait for for community to respond.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
 }
 }
?>

    <!-- category container starts here -->
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums</h1>
            <p class="lead"><?php echo $catdesc; ?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum.No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Remain respectful of
                other members at all times.
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
   echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <form action="' . $_SERVER["REQUEST_URI"]. '"method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short as possible.</small>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Elaborate Your Problem</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else{
      echo '<div class="container">
      <h1 class="py-2">Start a Discussion</h1>
        <p>You are not logged in. Please login to start a Discussion</p>
    </div>';
 
    }
   ?>
  
    <div class="container" id="ques">
        <h1 class="py-2">Browse Questions</h1>

        <?php 
$id = $_GET['catid'];
$sql = "SELECT * FROM `threads` WHERE threads_cat_id=$id;" ;
 $result = mysqli_query($conn, $sql);
 $noResult = true;
 while($row = mysqli_fetch_assoc($result)){
     $noResult = false;
    $id = $row['threads_id'];
    $title = $row['threads_title'];
    $desc = $row['threads_desc'];
    $thread_time = $row['timestamp'];
    $thread_user_id= $row['threads_user_id'];
    $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
   
 

       echo '<div class="media my-4">
       <img src="user.png" width="54px" class="mr-3" alt="...">
       <div class="media-body">'.
        '<h5 class="mt-0"> <a class="text-dark" href="thread.php?threadid=' . $id. '">'. $title . ' </a></h5>
           '. $desc . ' </div>'.'<div class="font-weight-bold my-0"> Asked by: '. $row2['user_email'] . ' at '. $thread_time. '</div>'.
   '</div>';

        }
        // echo var_dump($noResult);
        if ($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Threads found</p>
              <p class="lead"> Be the First person to ask a question"</p>
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