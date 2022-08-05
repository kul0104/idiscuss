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
    #maincontainer {
        min-height: 100vh;
    }
    .container{
        min-height: 100vh;
    }
    </style>

    <title> Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>


    <!-- search results start here -->
    <div class="container my-3">
        <h1 class="py-2">Search Results for <em>"<?php echo $_GET['search']?>"</em></h1>

        <?php
        $noresults = true;
        $query = $_GET["search"];
    $sql = "select * from threads where match(threads_title, threads_desc) against ('$query')";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['threads_title'];
        $desc = $row['threads_desc'];
        $thread_id = $row['threads_id'];
        $url = "thread.php?threadid=". $thread_id;
        $noresults = false;

        // display the search result
          echo '<div class="result">
          <h3> <a href="' .$url. '" class="text-dark">' .$title. '</a> </h3>
          <p>' .$desc. '</p>
          </div>';
         
        }
        if($noresults){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container" id="maincontainer>
              <p class="display-4">No Results found</p>
              <p class="lead"> suggestions: 
                          <li>Make sure that all words are spelled correctly.</li>
                          <li>Try different keywords.</li>
                          <li>Try more general keywords.</li>
                          </p>
            </div>  
             </div>';
        }
        ?>
        
    <?php include 'partials/_footer.php'; ?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

</body>

</html>