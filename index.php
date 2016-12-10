<?php
/*
 * @project phpParticleDashboard
 * @file    index.php
 * @authors Harrison Jones (harrison@hhj.me)
 * @date    March 13, 2015
 * @brief   A dashboard example using the phpParticle class
 */

/* For Debugging, Comment this in
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

session_start();
// checks the post and gets for p otherwise sets it to index
$page = isset($_REQUEST['p']) ? $_REQUEST['p'] : 'index';

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
        $renderedPage = "firmwareUpload";
        break;

    case 'signal_on':
        $action = 'signal_on';
        $renderedPage = 'deviceSignal';
        break;

    case 'signal_off':
        $action = 'signal_off';
        $renderedPage = 'deviceSignal';
        break;

    case 'tokens':
        $renderedPage = 'tokens';
        break;

    case 'newDevice':
        $renderedPage = 'claimDevice';
        break;

    case 'removeDevice':
        $renderedPage = 'removeDevice';
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