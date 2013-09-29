<?php 
session_start();
error_reporting(0);
require 'database/connect.php';
require 'functions/general.php';
require 'functions/users.php';
if(logged_in() === true){
    $Name = $_SESSION['Name'];
	$user_data = user_data($Name, 'Name', 'Password', 'FirstName', 'LastName', 'Email', 'Campus', 'IsModerator', 'IsProfessor');
	if(user_active($user_data['Name']) === false){
		session_destroy();
		header('Location: index.php');
		exit();
    }    
}else if(isset($_COOKIE['user'], $_COOKIE['pass'])){ //For cookies
    //Get username from dabatabse
    $user = user_name_from_cookie($_COOKIE['user']);   
    //If user was found
    if($user){   
        $check_pass = check_salted($user);
        echo $_COOKIE['pass'];        
        if($check_pass == $_COOKIE['pass']){
            // The user should be logged in
            $_SESSION['Name'] = $user;   
        }
    }   
}
$errors = array();
?>
