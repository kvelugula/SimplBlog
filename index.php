<?php 
include_once './lib/appconfig.php';
// Handle Actions
?>

<?php include_once("./html/page-header.php");?>
    <div id="content-main">
        <div id="bloghome-content"></div>
        <script type="text/javascript">
        $(document).ready(function(){
            var auto_refresh = setInterval(function () {
                $('#bloghome-content').load('./ajax-targets/latestposts.php');
            }, 5000);            
            $('#bloghome-content').load('./ajax-targets/latestposts.php');
        });
        </script>
    </div>
<?php include_once("./html/page-footer.php");?>