<?php
require_once './connect.inc.php';
if(isset($_POST["chatid1"]) && isset($_POST["chatid2"]))
{
    $chatid1=$_POST["chatid1"];
    $chatid2=$_POST["chatid2"];
    $query="SELECT * FROM `msg` WHERE `from`='$chatid1' AND `to`='$chatid2' OR `to`='$chatid1' AND `from`='$chatid2' ORDER BY  `msgtime`";
    $c=0;
    if($res=mysqli_query($con, $query))
    {
        
        while($dat=  mysqli_fetch_array($res))
        {
            $c=1;
            $msg=$dat['msg'];
            if($chatid1==$dat['from'])
            {
                echo "<div class='msgdiv1'><img src='http://graph.facebook.com/$chatid1/picture' class='chatpic'/>&nbsp;&nbsp;<span class='txtmsg'>$msg</span></div><hr/>";
            }
            else
            {
                echo "<div class='msgdiv2'><span class='txtmsg'>$msg&nbsp;&nbsp;</span><img src='http://graph.facebook.com/$chatid2/picture' class='chatpic'/></div><hr/>";
            }
        }
    }
    if($c==0)
    {
        echo "<center><h2 color='grey'>PLEASE SEND MESSAGE TO START CONVERSATION</h2></center>";
    }
}
?>
