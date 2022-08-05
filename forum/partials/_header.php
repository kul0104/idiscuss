<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark  fixed-top navbar-expand-md-2  py-4 sticky position:sticky">
<a href="/aanchaljaiswal" class="navbar-brand"> <img id="logo" src="car.png" width="50dp" alt="SuperCars"></a>
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';


         $sql= "SELECT category_name, category_id FROM `categories`";
         $result = mysqli_query($conn, $sql);
         while($row = mysqli_fetch_assoc($result)){
         echo '<li><a class="dropdown-item" href="threadlist.php?catid='. $row['category_id'].'">'. $row['category_name'].'Action</a></li>';
         }
        
        echo '</ul>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="contact.php">Contact</a>
    </li>
    </ul>
    <div class="mx-2">';


    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '<form class="d-flex" method="GET" action="search.php">
      <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
      </div>
    <p class="text-light my=0 mb-0"> welcome ' . $_SESSION['useremail']. '</p>
    <a href="partials/_logout.php" role="button" class="btn btn-outline-success ml-2">Logout</a></form>';
    }
    else{
      echo '<form class="d-flex">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
    
    </form>
    </div>
    <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
    }
   echo '</div> 
       </div>
      </nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You can  now login
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>