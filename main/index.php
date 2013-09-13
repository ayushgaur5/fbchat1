<?php
require 'fbconfig.php';   // Include fbconfig.php file
require_once './connect.inc.php';
?>
<!doctype html>
<html>
  <head>
    <title>Facebook Chat</title>
    <link rel="stylesheet" href="../style/css1.css" type="text/css"/>
 </head>
 <script src="../jquery.min.js"></script>

 <script>
     var xhr;
     var count=0;
     function closeuo()
     {
        $("#chatframe").css("display","none");
         $("#nochatframe").css("display","block");
         $("#msg").val("");
         if(count!=0)
         xhr.abort();
         count=0;
     } 
     function scrolld() {
        var sc   = $('#convtxt');
        var height = sc[0].scrollHeight;
        sc.scrollTop(height);//scroll
      }
      var dumptext=function(text)
      {
          $("#convtxt").html(text);
          //alert("Data: " + data + "\nStatus: " + status);
      }
      function getdata(frnd,tm)
      {
      		remote_url='backend.php?uname=<?php echo $fbuname; ?>&friend='+frnd+'&tm='+tm;
      		xhr=$.ajax({
	        type: "GET",
	        url: remote_url,
	        async: true,
	    }).done(function(data) {
	            
		            $("#convtxt").append(data);
		            scrolld();
	                    getdata(frnd,$("#last_time").val());
                   
	        });
	}
     $(document).ready(function(){
        var friend="";    
         $("#frbutton").click(function(){
             if($("#frbutton").val()=="Show")
                 {
	             $("#frbutton").animate({
	                 top:'130px'
	             });
	             $("#frlist").animate({
	                 top:'0'
	             });
	             $("#frbutton").val("Hide");
                }
            else
             {
                 $("#frbutton").animate({
                 top:'0px'
             });
             $("#frlist").animate({
                 top:'-130px'
             });
             $("#frbutton").val("Show");
             }
         });
         $(".frout").click(function()
        {
            friend=$(this).attr("id");
            closeuo();
            count=1;
            $("#chatframe").css("display","block");
            $("#nochatframe").css("display","none");
            $("#headmsg").html("<div  style='float: right;font-size: 12px;' value='Close[X]' onclick='closeuo();'><a href='#'>Close[X]</a></div>"+$(this).text());
            $("#convtxt").html("");
            $("#last_time").val("");
	            getdata(friend,"");	
	            scrolld();
            
            $("#msg").val("");
        });
        
     $("#addfrnd").click(function(){
         $(".trans").css("display","block");
         $(".popup").css("display","block");
     });
     $(".trans").click(function(){
         $(".trans").css("display","none");
         $(".popup").css("display","none");
    });
    $("#sendmsg").click(function(){
        if($("#msg").val()!='')
            {
           $.post("sendmsg.php",
            {
              msg:$("#msg").val(),
              chatid1:"<?php echo $fbuname; ?>",
              chatid2:friend
            });
            $("#msg").val("");
         }
        });
     
     $("#srchfrnd").keyup(function(){
         if($("#srchfrnd").val()=="")
             $("#srchlist").css("display","none");
         else
             {
                $("#srchlist").css("display","block");
                $.post("frndsrch.php",
                   {
                    txt:$("#srchfrnd").val(),
                    user:"<?php echo $fbuname; ?>"
                   },
                   function(data,status){
                     $("#srchlist").html(data);
                     //alert("Data: " + data + "\nStatus: " + status);
                   });
             }
     });
     $("#msg").keydown(function(){if(event.keyCode==13 && $("#msg").val()!='')
            
        {
            $.post("sendmsg.php",
            {
              msg:$("#msg").val(),
              chatid1:"<?php echo $fbuname; ?>",
              chatid2:friend
            });
             
            $("#msg").val("");
            }
        });
        
     });
 </script>
  <body>
      <div id="outer">
  <br/><br/>
  <?php if ($user): ?>      <!--  After user login  -->
    <center>
    <img src="https://graph.facebook.com/<?php echo $user; ?>/picture" style="width:120px;height:120px;margin:10px;border:2px solid white;border-radius: 100%;">
    <div style="font-size: 30px;"><?php echo $fbfullname; ?></div><div><a href="logout.php">Logout</a></div></center>
  <div id="frlist">
<?php

         $query="SELECT * FROM `user` WHERE `username` IN (SELECT `user2` FROM `friends` WHERE `user1`='$fbuname') ORDER BY `name`";
        $query_run=  mysqli_query($con, $query);
        $rows=  mysqli_num_rows($query_run);
        if($rows>0)
        {
             echo '<center>';
             while($res=  mysqli_fetch_array($query_run))
             {
                 $name=$res['name'];
                 $img=$res['username'];
                 if($fbuname!=$img)
                 {
                 	echo "<div class='frout' id='$img' ><center><img src='http://graph.facebook.com/$img/picture' title='$name' class='frclass'/><br/>$name</center></div>";
                 }
             }
             echo "<div id='addfrnd' title='ADD FRIEND'></div></center>";
         }
         else
             echo "<center><div id='addfrnd' title='ADD FRIEND'></div></center>";

?>
      </div><input type="button" id="frbutton" value="Show"/><center>
      <div id="nochatframe">
          <center><br/><br/><br/><h1 style="color: grey;">START CHAT BY CLICKING ON YOUR FRIEND</h1></center>
      </div>
      <div id="chatframe">
          <center>
          <div id="conv">
              <div id="headmsg"></div>
              <div id="convtxt">
                 
              </div>
          </div>
          </center>
          <input type="text" id="msg" onKeydown='Javascript: if (event.keyCode==13) sndmsg(); '/><input type="button" id="sendmsg" value="Send""/>
      </div></center>
    <?php else: ?>     <!-- Before login --> 
<div class="container">
<br/><br/><br/><br/><br/><br/><br/><br/><center>

<div>
<h1>WELCOME TO FACEBOOK CHAT</h1>
      <a href="<?php echo $loginUrl; ?>"><img src='../style/fb.jpg' style='border-radius:10px;'/></a></div>
</center> </div>
    <?php endif ?>
    <div class="trans">
          
      </div>
      <div class="popup">
          <center> <input type="text" id="srchfrnd" placeholder="Enter the name of your friend"/><br/>
              <div id="srchlist">
              </div></center>
      </div>
      </div>
      <input type='hidden' id='last_time' value=''/>
      <input type='hidden' id='check' value=''/>  
      <div id="info"><center>Welcome to FACEBOOK CHAT APPLICATION by Ayush Gaur (Best viewd at 1920 X 1080 resolution in Chrome Browser)</center></div>  
  </body>
</html>