<?php
// deviceSignal.php
/* For Debugging, Comment this in
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

if((@include 'phpParticle.class.php') === false)  die("Unable to load phpParticle class");

// Grab a new instance of our phpParticle object
$particle = new phpParticle();

// Set the internal debug to true. Note, calls made to $particle->debug(...) by you ignore this line and display always
$particle->setDebug(false);
// Set the debug calls to display pretty HTML format. Other option is "TEXT". Note, calls made to $particle->debug(...) display as set here
$particle->setDebugType("HTML");

// Set our access token (set in the phpConfig.config.php file)
$pieces = explode("::", $_SESSION['accessToken']);

$particle->setAccessToken($pieces[0]);
if(count($pieces) == 2) {
  $particle->setProductSlug($pieces[1]);
}

$signalError = false;

$deviceID = $_GET['deviceID'];

if($action == 'signal_on')
{
    if($particle->signalDevice($deviceID,1) === false)
    {
        $signalError = true;
    }
}
else
{
    if($particle->signalDevice($deviceID,0) === false)
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
            $particle->debug("Error: " . $particle->getError());
            $particle->debug("Error Source" . $particle->getErrorSource());
        ?>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="alert alert-success" role="alert">Success, your device was successfully signaled!</div>
        <b>Particle Cloud Response</b>
        <div class="well"><?php $particle->debug_r($particle->getResult()); ?></div>
        <?php
    }
    ?>
  </div>
</div>