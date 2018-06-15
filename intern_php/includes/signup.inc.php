<?php

  if(isset($_POST['submit'])){
    include_once 'dbh.inc.php';

    $first= mysqli_real_escape_string($conn, $_POST['first']);
    $last= mysqli_real_escape_string($conn, $_POST['last']);
    $email= mysqli_real_escape_string($conn, $_POST['email']);
    $uid= mysqli_real_escape_string($conn, $_POST['uid']);
    $passwrd= mysqli_real_escape_string($conn, $_POST['passwrd']);

    //error handling

    if(empty($first) || empty($last) || empty($email) || empty($uid) || empty($passwrd)){
      header("Location: ../signup.php?signup=empty");
      exit();
    }else{
      if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$", $last)){
        header("Location: ../signup.php?signup=invalid");
        exit();
      }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          header("Location: ../signup.php?signup=invalid email");
          exit();
        }else{
          $sql="SELECT * FROM users WHERE user-uid='$uid'";
          $result = mysqli_query($conn, $sql);
          $resultCheck = mysqli_num_rows($result);

          if ($resultCheck >0) {
            header("Location: ../signup.php?signup=usertaken");
            exit();
          }else{
            $hashedpwd=password_hash($passwrd, PASSWORD_DEFAULT);
            $sql= "INSERT INTO users (user_first, user_last, user_email, user_uid, user_passwrd) VALUES ('$first', '$last', '$email', '$uid', '$hashedpwd');";
            mysqli_query($conn, $sql);
            header("Location: ../signup.php?signup=signup successfull");
            exit();
          }
        }
      }
    }

  }else{
    header("Location: ../signup.php");
    exit();
  }
 ?>
