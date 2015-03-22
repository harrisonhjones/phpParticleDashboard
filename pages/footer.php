<?php
// footer.php
/* For Debugging, Comment this in
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

?>
    <div style="text-align: center" class="navbar navbar-fixed-bottom">
        Written by Harrison H. Jones
        <br/>
        <a href="https://github.com/harrisonhjones/phpSparkDashboard">Fork on GitHub</a>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <?php
    echo $endPageContent;
    ?>
  </body>
</html>
