<?php

function login($connect, $data) 
{ 
    //$users = mysqli_query($connect, "SELECT * FROM `users`");
    //$userList = [];

    //while($user = mysqli_fetch_assoc($users)){
    //    $userList[] = $user;
    //};

    //echo json_encode($userList);

    $email = $data['email']; $password = $data['password']; 
    $userData =''; 
    $user = mysqli_query($connect, "SELECT * FROM `users` where `email` = '$email' and password='$password'"); 
    $rowCount=$user->num_rows;
            
    if($rowCount > 0)
    {
        $userData = $user->fetch_object();
        $user_id=$userData->user_id;
        $userData = json_encode($userData);
        echo $userData;    
    }
    else 
    {
        echo '{"error":"Wrong email or password"}';
    }

    
}



function register($connect, $data) {

    $username = $data['username'];
    $password = $data['password'];
    $email = $data['email'];
    $name = $data['name'];

    $username_check = preg_match("/^[A-Za-z0-9_]{4,20}$/i", $username);
    $email_check = preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/i', $email);
    $password_check = preg_match('/^[A-Za-z0-9!@#$%^&*()_]{4,20}$/i', $password);
    
    if($username_check==0) 
        echo '{"error":"Invalid username"}';
    elseif($email_check==0) 
        echo '{"error":"Invalid email"}';
    elseif($password_check ==0) 
        echo '{"error":"Invalid password"}';

    elseif (strlen(trim($username))>0 && strlen(trim($password))>0 && strlen(trim($email))>0 && 
        $email_check>0 && $username_check>0 && $password_check>0)
    {
        

        $userData = '';
        
        $result = mysqli_query($connect, "SELECT * from `users` where `username`='$username' or `email`='$email'");
        $rowCount=$result->num_rows;
        //echo '{"text": "'.$rowCount.'"}';
        
        if($rowCount==0)
        {
                            
            mysqli_query($connect, "INSERT INTO users (`username`, `password`, `email`, `name`)
                        VALUES('$username','$password','$email','$name')");

            $userData ='';
            $userData = mysqli_query($connect, "SELECT * from `users` where `username`='$username' and `password`='$password'");
            $user_id=$userData->user_id;
            $userData = $userData->fetch_object();
            $userData = json_encode($userData);
            echo $userData;
        } 
        else {
            echo '{"error":"Username or Email already exists"}';
        }

    }
    else{
        echo '{"text":"Enter valid data"}';
    }
   
}