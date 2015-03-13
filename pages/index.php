<?php
// index.php

if((@include 'phpSpark.class.php') === false)  die("Unable to load phpSpark class");

// Grab a new instance of our phpSpark object
$spark = new phpSpark();

// Set the internal debug to true. Note, calls made to $spark->debug(...) by you ignore this line and display always
$spark->setDebug(false);
// Set the debug calls to display pretty HTML format. Other option is "TEXT". Note, calls made to $spark->debug(...) display as set here
$spark->setDebugType("HTML");

// Set our access token (set in the phpConfig.config.php file)
$spark->setAccessToken($_SESSION['accessToken']);


?>
<div class="container">
  <div class="starter-template">
    <h1>Your Devices</h1>
  </div>
</div>

<div class="container">
<?php
if($spark->listDevices() == true)
{
  ?>
<table class="table table-striped">
  <tr>
    <th>
      ID
    </th>
    <th>
      Name
    </th>
    <th>
      Last Heard
    </th>
    <th>
      Connected?
    </th>
    <th>
      View Device Details
    </th>
  </tr>

<?php
    foreach ($spark->getResult() as $device) {
?>
      <tr>
        <td>
          <?php echo $device['id']; ?>
        </td>
        <td>
          <?php echo $device['name']; ?>
        </td>
        <td>
          <?php echo $device['last_heard']; ?>
        </td>
        <td>
          <?php echo $device['connected']; ?>
        </td>
        <td>
          <a href="?p=device&deviceID=<?php echo $device['id']; ?>"><button type="button" class="btn btn-default">View Device</button></a>
        </td>
      </tr>
    
<?php
    }
    ?>
    </table>
    <?php
}
else
{
    echo "<div class=\"alert alert-warning\" role=\"alert\">ERROR: " . $spark->getError() . ". Source: " . $spark->getErrorSource() . "</div>";
}
?>
  </div>

