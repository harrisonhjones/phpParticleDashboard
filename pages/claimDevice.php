<?php
// firmwareUpload.php
// print_r($_POST);
//print_r($_FILES);

if((@include 'phpSpark.class.php') === false)  die("Unable to load phpSpark class");

// Grab a new instance of our phpSpark object
$spark = new phpSpark();

// Set the internal debug to true. Note, calls made to $spark->debug(...) by you ignore this line and display always
$spark->setDebug(false);
// Set the debug calls to display pretty HTML format. Other option is "TEXT". Note, calls made to $spark->debug(...) display as set here
$spark->setDebugType("HTML");

// Set our access token (set in the phpConfig.config.php file)
$spark->setAccessToken($_SESSION['accessToken']);

$claimError = false;

$deviceName = $_POST['deviceName'];
$deviceID = $_POST['deviceID'];

if($spark->claimDevice($deviceID) === false)
{
    $claimError = true;
}
else
{
    if($spark->setDeviceName($deviceID,$deviceName) === false)
    {
        $claimError = true;
    }
}
?>
<div class="container">
  <div class="starter-template">
    <h1>Claiming Device <i><?php echo $deviceID; ?></i> as '<?php echo $deviceName; ?>'</h1>
    <?php
    if($claimError === true)
    {
        ?>
        <div class="alert alert-danger" role="alert">Uh Oh! Something went wrong with claiming your device. See the error text below.</div>
        <b>Claim Device Error</b>
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
        <div class="alert alert-success" role="alert">Success, your device was successfully claimed!</div>
        <b>Spark Cloud Response</b>
        <div class="well"><?php $spark->debug_r($spark->getResult()); ?></div>
        <?php
    }
    ?>
  </div>
</div>