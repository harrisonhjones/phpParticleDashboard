<?php
// removeDevice.php
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

$removeError = false;

$deviceID = $_POST['deviceID'];

if($particle->deleteDevice($deviceID) === false)
{
    $removeError = true;
}
?>
<div class="container">
  <div class="starter-template">
    <h1>Removing Device <i><?php echo $deviceID; ?></i></h1>
    <?php
    if($removeError === true)
    {
        ?>
        <div class="alert alert-danger" role="alert">Uh Oh! Something went wrong with removing your device. See the error text below.</div>
        <b>Remove Device Error</b>
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
        <div class="alert alert-success" role="alert">Success, your device was successfully removed!</div>
        <b>Particle Cloud Response</b>
        <div class="well"><?php $particle->debug_r($particle->getResult()); ?></div>
        <?php
    }
    ?>
  </div>
</div>