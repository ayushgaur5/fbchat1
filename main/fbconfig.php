<?php
require_once '../fb-src/facebook.php';  // Include facebook SDK file
$facebook = new Facebook(array(
  'appId'  => '1415618678651615',   // Facebook App ID 
  'secret' => 'f2afc9470c793cbb724bcb6d8c5c6de0',  // Facebook App Secret
  'cookie' => true,    
));
$user = $facebook->getUser();

if ($user) {

    $user_profile = $facebook->api('/me');
          $fbid = $user_profile['id'];           // To Get Facebook ID
         $fbuname = $user_profile['username'];  // To Get Facebook Username
         $fbfullname = $user_profile['name'];    // To Get Facebook full name
         require_once './connect.inc.php';
         $query="SELECT `fbid` FROM `user` WHERE `fbid`='$fbid'";
         if($_q_r=  mysqli_query($con, $query))
         {
             $numrows= mysqli_num_rows($_q_r);
             if($numrows==0)
             {
                 $query="INSERT INTO `user` VALUES('$fbid','$fbuname','$fbfullname')";
                if(!mysqli_query($con, $query))
                {
                    //echo "Connection successful";
                  
                   die("Could not connect to database1.");
                }
             }
         }
         else
             die("Could not connect to database2.");

}
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array(
         'next' => 'http://fbchat.x10.mx/main/logout.php',  // Logout URL full path
        ));
} else {
 $loginUrl = $facebook->getLoginUrl(array(
        'scope'        => 'email', // Permissions to request from the user
        ));
}

?>