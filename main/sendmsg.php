<?php
require_once './connect.inc.php';
if(isset($_POST["chatid1"]) && isset($_POST["chatid2"]) && isset($_POST["msg"]))
{
    $chatid1=$_POST["chatid1"];
    $chatid2=$_POST["chatid2"];
    $msg=$_POST["msg"];
    $date=  date("Y-m-d H:i:s");
    $query="INSERT INTO `msg` VALUES('$chatid1','$chatid2','$date','$msg')";
    if(!mysqli_query($con, $query))
    {
        ?>
<script>
    alert("Failed to send message");
</script>
            <?php
    }
}
?>