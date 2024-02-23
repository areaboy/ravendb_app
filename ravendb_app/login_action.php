

<?php
error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

$email = strip_tags($_POST['email']);
$password = strip_tags($_POST['password']);


if ($email == ''){
echo "<div class='alert alert-danger' id='alerts_login'><font color=red>Email is empty</font></div>";
exit();
}


if ($password == ''){
echo "<div class='alert alert-danger' id='alerts_login'><font color=red>password is empty</font></div>";
exit();
}


// honey pot spambots
$emailaddress_pot =$_POST['emailaddress_pot'];
if($emailaddress_pot !=''){
//spamboot detected.
//Redirect the user to google site

echo "<script>
window.setTimeout(function() {
    window.location.href = 'https://google.com';
}, 1000);
</script><br><br>";

exit();
}







include('settings.php');


// Process Users Login Via RavenDB

$ch2 = curl_init();
$url2 ="$ravendb_database_url/databases/$ravendb_database_name/queries";
curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch2, CURLOPT_POSTFIELDS, "{ \n    \"Query\":\"from $users_tb where email = '$email'\" \n}");

$headers2 = array();
$headers2[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
$result2 = curl_exec($ch2);

$json2 = json_decode($result2, true);
$TotalResults = $json2['TotalResults'];

$http_status2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

$db_url = $json2['Url'];
$db_msg = $json2['Message'];


if($db_url !=''){
echo "<div class='alerts_fadesx' style='background:red;color:white;padding:10px;border:none;'><b>RavenDB Database Connection Error:</b>  
$db_msg. please  go to <b>(<a  style='color:white;' target='_blank' href='http://live-test.ravendb.net/studio/index.html#databases'>
http://live-test.ravendb.net/studio/index.html#databases</a>)</b> to create database First.. </div><br>";
exit();
}




if (curl_errno($ch2)) {
   $curl_error2 = curl_error($ch2);
echo "<div class='alerts_fades' style='background:green;color:white;padding:10px;border:none;'>Curl Requet Error: $curl_error2</div><br>";
}


if($result2 ==''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Please Ensure there is Internet Connection and Try Again...</div><br>";
exit();
}


$fullname_row = $json2['Results'][0]['fullname'];
$email_row = $json2['Results'][0]['email'];
$userid_row = $json2['Results'][0]['userid'];
$password_row = $json2['Results'][0]['password'];
$status_row = $json2['Results'][0]['status'];
$photo_row = $json2['Results'][0]['photo'];

if($http_status2 ==200){
echo "<div class='alerts_fades' style='background:green;color:white;padding:10px;border:none;'>API Call Successfully Made...</div><br>";

if($TotalResults == 1){

$password = strip_tags($_POST['password']);

//start hashed passwordless Security verify
if(password_verify($password,$password_row)){
            //echo "Password verified and ok";



$userid = $userid_row;
$fullname = $row['fullname'];



// initialize session if things where ok

session_start();
session_regenerate_id();
$timer = time();

// initialize session

// initialize session if things where ok.
$_SESSION['uid'] = $userid_row;
$_SESSION['fullname'] = $fullname_row;
$_SESSION['username'] = $userid_row;
$_SESSION['email'] = $email_row;
$_SESSION['photo'] = $photo_row;
$_SESSION['token'] = $timer;
$_SESSION['status'] = $status_row;


echo "<div style='background:green;padding:8px;color:white;border:none;'>Login sucessful <img src='ajax-loader.gif'></div>";
echo "<script>window.location='dashboard.php'</script>";




}
else{

echo "<div class='alerts_fades' style='background:red;padding:8px;color:white;border:none;'>Password does not match..</div>";

}


}else {

echo "<div class='alerts_fades' style='background:red;padding:8px;color:white;border:none;'>User with this Email <b>$email </b> does not Exist</div>";
}


}


curl_close($ch2);




}else{

echo "<div style='background:red;color:white;padding:10px;border:none;'>Direct Page Access Not Allowed</div><br>";


}









?>

<?php ob_end_flush(); ?>
