<?php

// index.php

?>
<br/>
<br/>
<div class="container">
    <?php
        if($loginError) 
            echo "<div class=\"alert alert-warning\" role=\"alert\">" . $loginError . "</div>";
    ?>

    <form class="form-signin" method="POST" action="index.php">
        <h2 class="form-signin-heading">Access Token</h2>
        <label for="inputEmail" class="sr-only">Access Token</label>
        <input type="text" name="inputAccessToken" id="inputAccessToken" class="form-control" placeholder="Access Token (from the spark.io/build page" required autofocus>
        <br/>
        <input type="hidden" name="p" id="p" value="login"/>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Submit</button>
    </form>
</div> <!-- /container -->