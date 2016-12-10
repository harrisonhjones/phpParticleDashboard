<?php
// index.php
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

?>
<div class="container">
  <div class="starter-template">
    <h1>Your Devices <a href="#" data-toggle="modal" data-target="#addDeviceModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></h1>
  </div>
</div>

<div class="container">
<?php
if($particle->listDevices() == true)
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
      Last Ip
    </th>
    <th>
      Last Handshake
    </th>
    <th>
      Firmware Product Id
    </th>
    <th>
      Firmware Version
    </th>
    <th>
      Quarantined
    </th>
    <th>
      Denied
    </th>
    <th>
      Connected
    </th>
    <th>
      Device Actions
    </th>
  </tr>

<?php
    foreach ($particle->getResult() as $device) {
?>

      <tr>
        <td>
          <?php echo $device['id']; ?>
        </td>
        <td>
          <?php echo $device['name']; ?>
        </td>
        <td>
          <?php echo $device['last_ip_address']; ?>
        </td>
        <td>
          <?php echo $device['last_handshake_at']; ?>
        </td>
        <td>
          <?php echo $device['firmware_product_id']; ?>
        </td>
        <td>
          <?php echo $device['firmware_version']; ?>
        </td>
        <td>
          <?php echo $device['quarantined'] ? $device['quarantined'] : "no"; ?>
        </td>
        <td>
          <?php echo $device['denied'] ? $device['denied'] : "no"; ?>
        </td>
        <td>
          <?php
            if($device['connected'] || $device['online'])
              echo "<span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> (YES)";
            else
              echo "<span class=\"glyphicon glyphicon-eye-close\" aria-hidden=\"true\"></span> (NO)";
          ?>
        </td>
        <td>
          <?php
            if($device['connected'] || $device['online'])
            {
          ?>
          <a href="?p=device&deviceID=<?php echo $device['id']; ?>"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> View Device</a><br/>
          
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Signal (<a href="?p=signal_on&deviceID=<?php echo $device['id']; ?>">On</a> | <a href="?p=signal_off&deviceID=<?php echo $device['id']; ?>">Off</a>)<br/>

          <a href="#" data-toggle="modal" data-target="#firmwareModal" data-device-name="<?php echo $device['name']; ?>" data-device-id="<?php echo $device['id']; ?>"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload Firmware</a><br/>


            <?php
          }
          ?>
          <a href="#" data-toggle="modal" data-target="#removeDeviceModal" data-device-name="<?php echo $device['name']; ?>" data-device-id="<?php echo $device['id']; ?>"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Remove Device</a><br/>
        </td>
      </tr>
    
<?php
    }
    ?>
    <tr>
    <th>
      ID
    </th>
    <th>
      Name
    </th>
    <th>
      Last Ip
    </th>
    <th>
      Last Handshake
    </th>
    <th>
      Firmware Product Id
    </th>
    <th>
      Firmware Version
    </th>
    <th>
      Quarantined
    </th>
    <th>
      Denied
    </th>
    <th>
      Connected
    </th>
    <th>
      Device Actions
    </th>
  </tr>
    </table>
    
    <?php
}
else
{
    echo "<div class=\"alert alert-warning\" role=\"alert\">ERROR: " . $particle->getError() . ". Source: " . $particle->getErrorSource() . "</div>";
}
?>
  </div>


<!-- Modal -->
<div class="modal fade" id="firmwareModal" tabindex="-1" role="dialog" aria-labelledby="firmwareModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="firmwareModal">Upload Firmware</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php" enctype="multipart/form-data">
          <input type="hidden" name="p" id="p" value="firmwareUpload"/>
          <div class="form-group">
            <label for="deviceID" class="control-label">Device ID:</label>
            <input type="text" class="form-control" name="deviceID" id="deviceID">
          </div>
          <div class="form-group">
            <label for="firmwareFile">File input</label>
            <input type="file" id="firmwareFile" name="firmwareFile" >
            <p class="help-block">Please only select a firmware .bin file only.</p>
          </div>
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
        <button class="btn btn-primary" type="submit">Upload Firmware</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addDeviceModal">Claim A New Device</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php">
          <input type="hidden" name="p" id="p" value="newDevice"/>
          <div class="form-group">
            <label for="deviceName" class="control-label">Device Name:</label>
            <input type="text" class="form-control" name="deviceName" id="deviceName">
          </div>
          <div class="form-group">
            <label for="deviceID" class="control-label">Device ID:</label>
            <input type="text" class="form-control" name="deviceID" id="deviceID">
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
        <button class="btn btn-primary" type="submit">Claim the Device</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="removeDeviceModal" tabindex="-1" role="dialog" aria-labelledby="removeDeviceModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="removeDeviceModal">Confirm Remove Device</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php">
          <input type="hidden" name="p" id="p" value="removeDevice"/>
          <div class="form-group">
            <label for="deviceID" class="control-label">Device ID:</label>
            <input type="text" class="form-control" name="deviceID" id="deviceID">
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-dismiss="modal" type="reset">Keep Device</button>
        <button class="btn btn-danger" type="submit">Remove Device</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$endPageContent = "
<script>
$('#firmwareModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var deviceID = button.data('device-id') // Extract info from data-* attributes
  var deviceName = button.data('device-name') // Extract info from data-* attributes

  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Upload firmware to \'' + deviceName + '\'')
  modal.find('#deviceID').val(deviceID)
})

$('#removeDeviceModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var deviceID = button.data('device-id') // Extract info from data-* attributes
  var deviceName = button.data('device-name') // Extract info from data-* attributes

  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Confirm Remove Device \'' + deviceName + '\' (' + deviceID + ')')
  modal.find('#deviceID').val(deviceID)
})
</script>";
?>

