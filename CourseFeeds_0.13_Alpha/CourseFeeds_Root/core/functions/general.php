<?php

//Checks if string is within limit
function string_range_check($min, $max, $string)
{
    if (strlen(trim($string)) < $min)
        return true;
    else
        if (strlen(trim($string)) > $max)
            return true;
        else
            return false;
}

//returns current time
function current_time()
{
    $time = mysql_fetch_array(mysql_query("SELECT NOW()"));
    return date($time['NOW()']);
}

//Function to send out emails
function email($to, $subject, $body)
{
    mail($to, $subject, $body, 'From: no-reply@coursefeeds.com'); // Change to your own domain
}

//If user is already logged in, this function redirects them to index.php
function logged_in_redirect()
{
    if (logged_in() === true)
    {
        header("Location: index.php");
        die();
    }
}

// For pages that require user to be log in and register
function protect_page()
{
    if (logged_in() === false)
    {
        header('Location: protected.php');
        exit();
    }
}

//Cleans any input sent to the database such as html and tags and invalid text symbols.
function array_sanitize(&$item)
{
    $item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

//
function sanitize($data)
{
    return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

//Outputs array of errors.
function output_errors($errors)
{
    return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}

function string_check($string)
{
    if ($string)
    {
        return $string;
    }
}

?>
