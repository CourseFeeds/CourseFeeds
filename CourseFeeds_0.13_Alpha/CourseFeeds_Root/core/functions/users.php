<?php

function recover($mode, $email)
{
    //These two variables are grab from the url.
    $mode = sanitize($mode);
    $email = sanitize($email);

    $user_data = user_data(user_name_from_email($email), 'FirstName', 'Name');
    $name = user_name_from_email($email);

    if ($mode == 'username')
    {
        //recover username
        email($email, 'Your Username', "Hello " . $user_data['FirstName'] . ",\n\nYour username is: " .
            $user_data['Name'] . "/n/n-CourseFeeds.com"); // Change to your own domain 

    } else
        if ($mode == 'password')
        {
            $lost_password_code = substr(md5(rand(999, 999999)), 0, 32);
            mysql_query("UPDATE `User` SET `EmailCode` = '$lost_password_code' WHERE `Name` = '$name'");
            email($email, 'Your Password recovery', "
           \n\nReset your password by clicking on the following link:
           \nhttp://www.coursefeeds.com/forgot-password.php?email=" . $email . // Change to your own domain
                "&lost_password_code=" . $lost_password_code . "
           
           \n\n-CourseFeeds
           ");
        }

}

function password_recovery($email, $lost_password_code)
{
    //This function is used to verify that the email and password_code match the database.
    $email = mysql_real_escape_string($email);

    if (mysql_result(mysql_query("SELECT COUNT(`Name`) FROM `User` WHERE `Email` = '$email' AND `EmailCode` = '$lost_password_code'"),
        0) == 1)
    {
        return true;
    } else
    {
        return false;
    }
}

function email_code_reset($user_name)
{
    $name = $user_name;

    $lost_password_code = substr(md5(rand(999, 999999)), 0, 32);
    mysql_query("UPDATE `User` SET `EmailCode` = '$lost_password_code' WHERE `Name` = '$name'");
}

function activate($email, $email_code)
{
    //This function activates the user account after first registering.

    $email = mysql_real_escape_string($email);
    $email_code = mysql_real_escape_string($email_code);

    if (mysql_result(mysql_query("SELECT COUNT(`Name`) FROM `User` WHERE `Email` = '$email' AND `EmailCode` = '$email_code' AND `Active` = 0"),
        0) == 1)
    {
        mysql_query("UPDATE `User` SET `Active` = 1 WHERE `Email` = '$email'");
        email_code_reset(user_name_from_email($email));
        return true;
    } else
    {
        return false;
    }
    
}

function update_user($update_data)
{
    //This is use to update user information.
    global $Name;
    $update = array();
    array_walk($update_data, 'array_sanitize');

    foreach ($update_data as $field => $data)
    {
        $update[] = '`' . $field . '` = \'' . $data . '\'';
    }

    mysql_query("UPDATE `User` SET " . implode(', ', $update) . " WHERE `Name` = '$Name'");

}

function change_password($user_name, $password)
{
    $Name = $user_name;
    $password = md5($password);

    mysql_query("UPDATE `User` SET `Password` = '$password' WHERE `Name` = '$Name'");
    email_code_reset($Name);
}

function register_user($register_data)
{
    array_walk($register_data, 'array_sanitize');
    $register_data['Password'] = md5($register_data['Password']);

    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $data = '\'' . implode('\', \'', $register_data) . '\'';

    mysql_query("INSERT INTO `User` ($fields) VALUES ($data)");

    email($register_data['Email'], 'Activate your account', "		
		\n\nPlease confirm your account by clicking on this link:
		\n http://www.coursefeeds.com/activate.php?email=" . $register_data['Email'] . // Change to your own domain
        "&email_code=" . $register_data['EmailCode'] . "
		
		\n\n-CourseFeeds
	");
}

function user_count()
{
    //simply returns how many users are registered to our site.
    return mysql_result(mysql_query("SELECT COUNT(`Name`) FROM `User` WHERE `Active` = 1"),
        0);
}

function user_data($Name)
{
    $data = array();
    $Name = (string )$Name;

    $func_num_args = func_num_args();
    $func_get_args = func_get_args();

    if ($func_num_args > 1)
    {
        unset($func_get_args[0]);

        $fields = '`' . implode('`, `', $func_get_args) . '`';
        $data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `User` WHERE `Name` = '$Name'"));

        return $data;
    }
}

function logged_in()
{
    return (isset($_SESSION['Name'])) ? true : false;
}

function user_exists($username)
{
    //Checks to see if username is being used/ exists.
    $username = sanitize($username);
    
    $query = mysql_query("SELECT COUNT(`Name`) FROM `User` WHERE `Name` = '$username'");
    return (mysql_result($query, 0) == 1) ? true : false;
}

function email_exists($email)
{
    $username = sanitize($email);
    
    $query = mysql_query("SELECT COUNT(`Name`) FROM `User` WHERE `Email` = '$email'");
    return (mysql_result($query, 0) == 1) ? true : false;
}

function user_active($username)
{
    $username = sanitize($username);
    
    $query = mysql_query("SELECT COUNT(`Name`) FROM `User` WHERE `Name` = '$username' AND `Active` = 1");
    return (mysql_result($query, 0) == 1) ? true : false;
}

function user_name_from_email($email)
{
    $email = sanitize($email);
    
    $query = "SELECT * FROM `User` WHERE `Email` = '$email'";
    $query_result = mysql_query($query);
    $query_row = mysql_fetch_array($query_result);
    $query_name = $query_row['Name'];
    
    if ($query_name)
        return $query_name;
    else
        return false;
}

function user_name_from_cookie($username)
{
    $username = sanitize($username);
    
    $query = "SELECT * FROM `User` WHERE `Name` = '$username'";
    $query_result = mysql_query($query);
    $query_row = mysql_fetch_array($query_result);
    $query_name = $query_row['Name'];
    
    if ($query_name)
        return $query_name;
    else
        return false;
    
}

function get_salted($username)
{
    $username = sanitize($username);
    
    $query = "SELECT * FROM `User` WHERE `Name` = '$username'";
    $query_result = mysql_query($query);
    $query_row = mysql_fetch_array($query_result);
    $query_string = $query_row['Password'];
    
    //if the query was a success
    if ($query_string)
    {
        //Create salted string.
        $salted_string = sha1(sha1($query_string) . sha1('lioLn1p#@l1pc0urs30xp'));
        return $salted_string;
    }
       
    else
        return false;
}

function login($username, $password)
{
    $username = sanitize($username);
    $password = md5($password);

    $query = "SELECT * FROM `User` WHERE `Name` = '$username' AND `Password` = '$password'";
    $query_result = mysql_query($query);
    $query_row = mysql_fetch_array($query_result);
    $query_name = $query_row['Name'];

    if ($query_name)
        return $query_name;
    else
        return false;
}

?>
