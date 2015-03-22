<?php
// deviceSignal.php
/* For Debugging, Comment this in
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

if((@include 'phpSpark.class.php') === false)  die("Unable to load phpSpark class");

// Grab a new instance of our phpSpark object
$spark = new phpSpark();

// Set the internal debug to true. Note, calls made to $spark->debug(...) by you ignore this line and display always
$spark->setDebug(false);
// Set the debug calls to display pretty HTML format. Other option is "TEXT". Note, calls made to $spark->debug(...) display as set here
$spark->setDebugType("HTML");

// Set our access token (set in the phpConfig.config.php file)
$spark->setAccessToken($_SESSION['accessToken']);

$signalError = false;

$deviceID = $_GET['deviceID'];

if($action == 'signal_on')
{
    if($spark->signalDevice($deviceID,1) === false)
    {
        $signalError = true;
    }
}
else
{
    if($spark->signalDevice($deviceID,0) === false)
    {
       $signalError = true;
    }  
}
?>
<div class="container">
  <div class="starter-template">
    <h1>Signaling Device <i><?php echo $deviceID; ?></i></h1>
    <?php
    if($signalError === true)
    {
        ?>
        <div class="alert alert-danger" role="alert">Uh Oh! Something went wrong with the sending the signal to your device. See the error text below.</div>
        <b>Signal Device Error</b>
        <div class="well">
        <?php
            $spark->debug("Error: " . $spark->getError());
            $spark->debug("Error Source" . $spark->getErrorSource());
        ?>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="alert alert-success" role="alert">Success, your device was successfully signaled!</div>
        <b>Spark Cloud Response</b>
        <div class="well"><?php $spark->debug_r($spark->getResult()); ?></div>
        <?php
    }
    ?>
  </div>
</div>