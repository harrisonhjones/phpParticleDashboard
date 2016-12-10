<?php
// device.php
/*For Debugging, Comment this in
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

// Grab a specific device's info
$deviceID = $_GET['deviceID'];
if(!$deviceID)
{
  $deviceID = $_POST['deviceID'];
}

if($particle->getAttributes($deviceID) == true)
{
  $results = $particle->getResult();
?>
<div class="container">
  <div class="starter-template">
    <h1>Device <i><?php echo $results['name']; ?></i></h1>
  </div>


  <?php

  if($_POST['function'])
  {
    if($particle->callFunction($deviceID, $_POST['function'], $_POST['parameter']) == true)
    {
      $functionResult = $particle->getResult();
      echo "<div class=\"alert alert-success\" role=\"alert\">Function '" . $_POST['function'] . "' called with parameter '" . $_POST['parameter'] . "'. Return value = '" . $functionResult['return_value'] . "'</div>";
    }
    else
    {
      echo "<div class=\"alert alert-warning\" role=\"alert\">ERROR: " . $particle->getError() . ". Source: " . $particle->getErrorSource() . "</div>";
    }
  }
  ?>
</div>

  <div class="container">
    <h2>Variables<!-- (<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>)--></h2>
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
          if($particle->getVariable($deviceID, $variableKey) == true)
          {
              $resVariable = $particle->getResult();
              echo $resVariable['result'];
          }
          else
          {
              $particle->debug("Error: " . $particle->getError());
              $particle->debug("Error Source" . $particle->getErrorSource());
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
    echo "<div class=\"alert alert-warning\" role=\"alert\">ERROR: " . $particle->getError() . ". Source: " . $particle->getErrorSource() . "</div>";
}
?>
  </div>

  <div class="container">
    <h2>Device Information</h2>
    <table class="table table-striped">
      <tr>
        <th>
          Key
        </th>
        <th>
          Value
        </th>
      </tr>
      
      <?php 
      foreach ($results as $key => $value) {
        ?>
        <tr>
        <td>
          <?php echo $key;?>
        </td>
        <td>
          <?php echo $value;?>
        </td>
        </tr>
        <?php
      }
      ?>
      
    </table>
  </div>