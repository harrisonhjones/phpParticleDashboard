<?php
// tokens.php
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
    <h1>Your Access Tokens</h1>
  </div>
</div>

<div class="container">
<?php
if($particle->listTokens() == true)
{
  ?>
<table class="table table-striped">
  <tr>
    <th>
      Access Token
    </th>
    <th>
      Expires At
    </th>
    <th>
      Client / Issuer
    </th>
    <th>
      Token Actions
    </th>
  </tr>

<?php
    foreach ($particle->getResult() as $token) {
?>
      <tr>
        <td>
          <?php echo $token['token']; ?>
        </td>
        <td>
          <?php echo $token['expires_at']; ?>
        </td>
        <td>
          <?php
            if($token['client'] == "__PASSWORD_ONLY__")
              echo "Manually Issued";
            else
              echo $token['client'];
          ?>
        </td>
        <td>
          <a href="#" data-toggle="modal" data-target="#deleteTokenModal" data-token-id="<?php echo $token['token']; ?>">Delete Token</a><br/>
        </td>
      </tr>
    
<?php
    }
    ?>
    <tr>
    <th>
      Access Token
    </th>
    <th>
      Expires At
    </th>
    <th>
      Client / Issuer
    </th>
    <th>
      Token Actions
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
<div class="modal fade" id="deleteTokenModal" tabindex="-1" role="dialog" aria-labelledby="deleteTokenModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="deleteTokenModal">Confirm Delete Token</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php">
          <input type="hidden" name="p" id="p" value="deleteToken"/>
          <div class="form-group">
            <label for="data-token-id" class="control-label">Access Token:</label>
            <input type="text" class="form-control" name="data-token-id" id="data-token-id">
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-dismiss="modal" type="reset">Keep Token</button>
        <button class="btn btn-danger" type="submit">Delete Token</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php
$endPageContent = "
<script>
$('#deleteTokenModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var data-token-id = button.data('data-token-id') // Extract info from data-* attributes

  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Confirm Delete Token \'' + data-token-id + '\'')
  modal.find('#data-token-id').val(data-token-id)
})
</script>";
?>