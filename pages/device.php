<?php
// device.php
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

// Grab a specific device's info
$deviceID = $_GET['deviceID'];
if(!$deviceID)
{
  $deviceID = $_POST['deviceID'];
}

if($spark->getDeviceInfo($deviceID) == true)
{
  $results = $spark->getResult();
?>
<div class="container">
  <div class="starter-template">
    <h1>Device <i><?php echo $results['name']; ?></i></h1>
  </div>


  <?php

  if($_POST['function'])
  {
    if($spark->doFunction($deviceID, $_POST['function'], $_POST['parameter']) == true)
    {
      $functionResult = $spark->getResult();
      echo "<div class=\"alert alert-success\" role=\"alert\">Function '" . $_POST['function'] . "' called with parameter '" . $_POST['parameter'] . "'. Return value = '" . $functionResult['return_value'] . "'</div>";
    }
    else
    {
      echo "<div class=\"alert alert-warning\" role=\"alert\">ERROR: " . $spark->getError() . ". Source: " . $spark->getErrorSource() . "</div>";
    }
  }
  ?>
</div>

  <div class="container">
    <h2>Variables</h2>
    <table class="table table-striped">
      <tr>
        <th>
          Variable Name
        </th>
        <th>
          Type
        </th>
        <th>
          Last Value
        </th>
      </tr>
      <?php
      foreach ($results['variables'] as $variableKey => $variableValue) {
      ?>
      <tr>
        <td>
          <?php echo $variableKey;?>
        </td>
        <td>
          <?php echo $variableValue;?>
        </td>
        <td>
          <?php
          if($spark->getVariable($deviceID, $variableKey) == true)
          {
              $resVariable = $spark->getResult();
              echo $resVariable['result'];
          }
          else
          {
              $spark->debug("Error: " . $spark->getError());
              $spark->debug("Error Source" . $spark->getErrorSource());
          }
          ?>
        </td>
      </tr>
      <?php
      }
      ?>
    </table>
  </div>
  
  <div class="container">
    <h2>Functions</h2>
    <table class="table table-striped">
      <tr>
        <th>
          Function Name
        </th>
        <th>
          Parameter
        </th>
        <th>
          Action
        </th>
      </tr>
      <?php
      foreach ($results['functions'] as $function) {
      ?>
      <tr>
        <form class="form-signin" method="POST" action="index.php">
          <input type="hidden" name="p" value="device"/>
          <input type="hidden" name="function" value="<?php echo $function; ?>"/>
          <input type="hidden" name="deviceID" value="<?php echo $deviceID; ?>"/>
        <td>
            <?php echo $function;?>
        </td>
        <td>
            <input type="text" name="parameter" id="parameter" class="form-control" placeholder="" required autofocus />
        </td>
        <td>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
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

