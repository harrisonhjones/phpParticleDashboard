<?php

/*
 * @project phpSparkDashboard
 * @file    index.php
 * @authors Harrison Jones (harrison@hhj.me)
 * @date    March 13, 2015
 * @brief   A dashboard example using the phpSpark class
 */

session_start();

$page = $_GET['p'];

if(!$page)
  $page = $_POST['p'];


$renderedPage = "login";

switch ($page) {
    case 'login':
        if($_POST['inputAccessToken'] != "DS")
        { 
          $_SESSION['accessToken'] = $_POST['inputAccessToken'];
          $renderedPage = "index";
        }
        else
        {
          $loginError = "Bad/missing username";
          // unset($_SESSION['accessToken']);
          // setcookie('accessToken', '', time() - 3600); // empty value and old timestamp
          $renderedPage = "login";
        }
        break;

    case 'logout':
      unset($_SESSION['accessToken']);      
      $renderedPage = "login";
      $loginError = "You have been logged out!";
      session_destroy();
      break;

    case 'devices':
        $renderedPage = "index";
        break;

    case 'device':
        $renderedPage = "device";
        break;
    
    case 'firmwareUpload':
        $renderedPage = "404";
        break;

    default:
      // Don't do anything
      if($_SESSION['accessToken'])
        $renderedPage = "index";
      else
        $renderedPage = "login";
      break;
}

// Load the page header
if((@include 'pages/header.php') === false)  die("Unable to load page header");
if((@include 'pages/' . $renderedPage . '.php') === false)  die("Unable to load desired page");
if((@include 'pages/footer.php') === false)  die("Unable to load page footer");