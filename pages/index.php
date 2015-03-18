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
      Device Actions
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
          <?php
            if($device['connected'])
              echo "Yes";
            else
              echo "No";
          ?>
        </td>
        <td>
          <?php
            if($device['connected'])
            {
          ?>
          <a href="?p=device&deviceID=<?php echo $device['id']; ?>"><button type="button" class="btn btn-default">View Device</button></a>
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#firmwareModal" data-device-name="<?php echo $device['name']; ?>" data-device-id="<?php echo $device['id']; ?>">Upload Firmware</button>
            <?php
          }
          else
          {
            echo "Offline devices cann't be manipulated";
          }
          ?>
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

<!-- Modal -->
<<div class="modal fade" id="firmwareModal" tabindex="-1" role="dialog" aria-labelledby="firmwareModal" aria-hidden="true">
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
            <label for="device-id" class="control-label">Device ID:</label>
            <input type="text" class="form-control" name="device-id" id="device-id" disabled>
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
  modal.find('#device-id').val(deviceID)
})
</script>";
?>