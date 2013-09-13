<?php
require_once './connect.inc.php';
if(isset($_POST['uname']))
{
    $user=$_POST["user"];
    $uname=$_POST['uname'];
    $query1="INSERT INTO `friends` VALUES('$user','$uname')";
    $query2="INSERT INTO `friends` VALUES('$uname','$user')";
    if(mysqli_query($con, $query1) and mysqli_query($con, $query2))
    {
       echo "Successfully Added!"; 
    }
    else
    {
        echo "Please try again";
    }
    die();
    
}

$fbuser=$_POST['user'];
$txt=$_POST["txt"];
if(!empty($txt))
{
$query="SELECT * FROM `user` WHERE `name` like '$txt%' AND `username` NOT IN (SELECT `user2` FROM `friends` WHERE `user1`='$fbuser') ORDER BY `name`";
$query_run=  mysqli_query($con, $query);
$rows=  mysqli_num_rows($query_run);
if($rows>=0)
{
    $i=0;
    while($dat= mysqli_fetch_array($query_run))
    {
        if($i<5)
        {
            $uname=$dat['username'];
            echo "<div class='selfrnd' value='$uname'><img src='http://graph.facebook.com/".$uname."/picture'/><p>".$dat["name"];
            if(1)
            {
                echo "<input type='button' value='+' style='float:right;font-size:20px;margin-top:-10px;' class='addbutton' id='$uname'/>";
            }
            echo "</p></div>";
        }
        $i++;
    }
    echo "</table>";
}
}
?>
<script>$('.addbutton').click(function(){
        
        $.post("frndsrch.php",
            {
              uname:$(this).attr("id"),
              user:"<?php echo $fbuser; ?>"
            },
        function(data,status){
                     //$("#srchlist").html(data);
                     alert(data);
                     window.location.assign("../index.php");
                   });
                   $(this).hide();
     });
</script>