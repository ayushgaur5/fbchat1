<?php
 require_once './connect.inc.php';
 set_time_limit(0);
 $disp='';
 $tm='';
 while(1)
 { 
     $num=0;
    if(isset($_GET["uname"]) && isset($_GET["friend"]))
    {
        $chatid1=$_GET["uname"];
        $chatid2=$_GET["friend"];
        $time=$_GET["tm"];
        if($time=='')
            $query="SELECT * FROM `msg` WHERE `from`='$chatid1' AND `to`='$chatid2' OR `to`='$chatid1' AND `from`='$chatid2' ORDER BY `msgtime`";
        else
            $query="SELECT * FROM `msg` WHERE (`from`='$chatid1' AND `to`='$chatid2' OR `to`='$chatid1' AND `from`='$chatid2') AND `msgtime`>'$time' ORDER BY `msgtime`";
        
        if($res=mysqli_query($con, $query))
        {
            $num=  mysqli_num_rows($res);
            while($dat=  mysqli_fetch_array($res))
            {
                
                $msg=$dat['msg'];
                $frm=$dat['from'];
                $tm=$dat['msgtime'];
                if($chatid1==$dat['from'])
                {
                    $disp=$disp."<div class='msgdiv1'><img src='http://graph.facebook.com/$chatid1/picture' title='$frm (Sent at $tm)' class='chatpic'/>&nbsp;&nbsp;<span class='txtmsg'>$msg</span></div><hr/>";
                }
                else
                {
                    $disp=$disp."<div class='msgdiv2'><span class='txtmsg'>$msg&nbsp;&nbsp;</span><img src='http://graph.facebook.com/$chatid2/picture' title='$frm (Recieved at $tm)' class='chatpic'/></div><hr/>";
                }
            }
            if($num>0)
                break;
        }
     
    }
   // sleep(1);// a little break to unload the server CPU
 }
 echo $disp."<script>$('#last_time').val('$tm');</script>";
 flush(); // used to send the echoed data to the client
 ob_flush();
  ?>