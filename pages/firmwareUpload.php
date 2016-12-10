<?php
// firmwareUpload.php
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

// Handle the firmware upload
$parts = explode(".",$_FILES['firmwareFile']['name']);
$ext = $parts[count($parts)-1];

$fileError = false;
// If there was a problem uploading the file let the user know
if ($_FILES["firmwareFile"]["error"] > 0)
{
    if($_FILES["firmwareFile"]["error"]!=UPLOAD_ERR_NO_FILE)
    {
        $fileError = "Error, file upload error " . $_FILES["firmwareFile"]["error"];
    }
}
else
{
    $target_path = 'tempFirmware/' . uniqid() . "." . $ext; 
    //print_r_html($_FILES);
    //echo "Target: " . $target_path . "<BR/>";
    //echo "Temp Name: " . $_FILES['file']['tmp_name'] . "<BR/>";
    if(!move_uploaded_file($_FILES['firmwareFile']['tmp_name'], $target_path)) {
        $fileError = "Error, file upload error. Unable to move file";
    }
}

//$target_path = ('/' . $target_path);
$deviceID = $_POST['deviceID'];


if($fileError == false)
{
    if ($ext == "bin")
    {

        $firmwareUploadResult = $particle->uploadFirmware($deviceID,"firmware.bin",$target_path,true);
        // unlink($target_path);
    }
    else
    {
        $fileError = "Non binary firmware files are not yet supported! Please upload a compiled binary as a .bin file";
        //$firmwareUploadResult = $particle->uploadFirmware($_POST['device-id'],$target_path,false);
        unlink($target_path);
    }
}
?>
<div class="container">
  <div class="starter-template">
    <h1>Uploading Firmware to Device <i><?php echo $deviceID; ?></i></h1>
    <?php
    if($fileError != false)
    {
        ?>
        <div class="alert alert-danger" role="alert">Uh Oh! Something went wrong with the firmware file upload. See the error text below.</div>
        <b>File Upload Error</b>
        <div class="well"><?php echo $fileError; ?></div>
        <?php
    }
    else
    {
        if($firmwareUploadResult)
        {
            ?>
            <div class="alert alert-success" role="alert">Success, your firmware is being uploaded to your device right now!</div>
            <b>Particle Cloud Response</b>
            <div class="well"><?php $particle->debug_r($particle->getResult()); ?></div>
            <?php
        }
        else
        {
            ?>
            <div class="alert alert-danger" role="alert">Uh Oh! Something went wrong with the firmware upload. See the error text below.</div>
            <b>Particle Cloud Response</b>
            <div class="well">Error: <?php $particle->debug("Error: " . $particle->getError()); ?><br/><?php $particle->debug("Error Source" . $particle->getErrorSource()); ?></div>
            <?php
        }
    }
    ?>
  </div>
</div>