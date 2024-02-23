<?php
error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

$password = strip_tags($_POST['password']);
$fullname = strip_tags($_POST['fullname']);
$email = strip_tags($_POST['email']);
$status = strip_tags($_POST['status']);
$mt_id=rand(0000,9999);
$dt2=date("Y-m-d H:i:s");
$ipaddress = strip_tags($_SERVER['REMOTE_ADDR']);
$time=time();
$username = time();
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


$file_content = strip_tags($_POST['file_fname']);
if ($file_content == ''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>File Uploads is Empty.</div><br>";
exit();
}



if ($password == ''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Password is Empty.</div><br>";
exit();
}

if ($fullname == ''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Fullname is Empty</div><br>";
exit();
}

if ($email == ''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Email is Empty</div><br>";
exit();
}

$em= filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$em){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Email is not Valid</div><br>";
exit();
}




$upload_path = "uploads/";


$filename_string = strip_tags($_FILES['file_content']['name']);
// thus check files extension names before major validations

$allowed_formats = array("PNG", "png", "gif", "GIF", "jpeg", "JPEG", "BMP", "bmp","JPG","jpg");
$exts = explode(".",$filename_string);
$ext = end($exts);

if (!in_array($ext, $allowed_formats)) { 
echo "<div id='alertdata_uploadfiles' class='alerts alert-danger'>File Formats not allowed. Only Images are allowed.<br></div>";
exit();
}




 //validate file names, ensures directory tranversal attack is not possible.
//thus replace and allowe filenames with alphanumeric dash and hy

//allow alphanumeric,underscore and dash

$fname_1= preg_replace("/[^\w-]/", "", $filename_string);

// add a new extension name to the uploaded files after stripping out its dots extension name
$new_extension = ".png";
$fname = $fname_1.$new_extension;





// for security reasons, you migh want to avoid files with more than one dot extension name
//file like fred.exe.png might contain virus. only ask the user to rename files to eg fred.png before uploads

 $fname_dot_count = substr_count($fname,".");
if($fname_dot_count >1){
echo "<div id='alertdata_uploadfiles2' class='alerts alert-danger'>
Your files <b>$filename_string</b> has <b>($fname_dot_count dot extension names)</b>
File with more than one <b>dot(.) extension name are not allowed.
you can rename and ensure it has only one dot extension eg: <b>example.png</b>
</b></div>";
exit();

}


$fsize = $_FILES['file_content']['size']; 
$ftmp = $_FILES['file_content']['tmp_name'];

//give file a random names
$filecontent_name = $username.time();
//$filecontent_name = 'fred1';


if ($fsize > 5 * 1024 * 1024) { // allow file of less than 5 mb
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>File greater than 5mb not allowed<br></div>";
exit();
}

// Check if file already exists
if (file_exists($upload_path . $filecontent_name.'.'.$ext)) {
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>This uploaded File <b>$filecontent_name.$ext</b> already exist<br></div>";
exit(); 
}


$allowed_types=array(
'application/json',
'application/octet-stream',
'text/plain',
'image/gif',
    'image/jpeg',
    'image/png',
'image/jpg',

'image/GIF',
    'image/JPEG',
    'image/PNG',
'image/JPG'
);



if ( ! ( in_array($_FILES["file_content"]["type"], $allowed_types) ) ) {
  echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Only Images are allowed bro..<br><br></div>";
exit();
}



// Calling getimagesize() function 
//$image_info = getimagesize("team1.png"); 
//print_r($image_info); 

$image_info =getimagesize($_FILES['file_content']['tmp_name']);

    $width = $image_info[0];
    $height = $image_info[1];
    $mime_image = $image_info['mime'];
/*
//validate file dimension eg 400 by 250
if ($width > "400" || $height > "250") {
       echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>file upload dimension must not be more than 400(width) by 250(height)</div>";
exit();

}
*/


// check file validation using getimagesizes
 if ($image_info === FALSE) {
           echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>cannot determine the image type</div>";
exit();
        }



if ( ! ( in_array($mime_image, $allowed_types) ) ) {
  echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Only Image types are allowed..<br><br></div>";
exit();
}



if (($image_info[2] !== IMAGETYPE_GIF) && ($image_info[2] !== IMAGETYPE_JPEG) && ($image_info[2] !== IMAGETYPE_PNG)) {
           echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>only image format gif,jpg, png are allowed..</div>";
exit();
        }





//validate image using file info  method
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file_content']['tmp_name']);

if ( ! ( in_array($mime, $allowed_types) ) ) {
  echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Only Images are allowed...<br></div>";
exit();
}
finfo_close($finfo);







//hash password before sending it to database...
$options = array("cost"=>4);
$hashpass = password_hash($password,PASSWORD_BCRYPT,$options);



include('settings.php');


// Check if User with Email Address already exist

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
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Curl Request Error: $curl_error2</div><br>";
}


if($result2 ==''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Please Ensure there is Internet Connection and Try Again...</div><br>";
exit();
}



if($http_status2 ==200){
//echo "<div class='alerts_fades' style='background:green;color:white;padding:10px;border:none;'>API Call Successfully Made...</div><br>";

if($TotalResults == 1){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>User with This Email Address <b>$email </b> Already Exist</div>";
exit();
}
}
curl_close($ch2);



// start file uploads
if (move_uploaded_file($ftmp, $upload_path . $filecontent_name.'.'.$ext)) {


//insert into database
$final_filename =  $filecontent_name.'.'.$ext;

// insert into RavenDB Database
$ch = curl_init();
$url ="$ravendb_database_url/databases/$ravendb_database_name/docs?id=$users_tb/$time";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');


curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \n  \"photo\":\"$final_filename\", \n   \"fullname\":\"$fullname\", \n    \"email\":\"$email\",\n   \"password\":\"$hashpass\",\n   \"userid\":\"$time\",\n   \"status\":\"$status\",\n   \"@metadata\":{\n        \"@collection\":\"$users_tb\"\n    }\n}");


$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
//$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);

$json = json_decode($result, true);
$res_id = $json['Id'];


$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
   $curl_error = curl_error($ch);

echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Curl Requet Error: $curl_error</div><br>";
}



if($result ==''){

echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Please Ensure there is Internet Connection and Try Again...</div><br>";
exit();
}



if($http_status ==201){

echo "<div class='alerts_fadesx' style='background:green;color:white;padding:10px;border:none;'>API Call Successfully Made...</div><br>";


if($res_id !=''){

echo "<div class='alerts_fadesx' style='background:green;color:white;padding:10px;border:none;'>Data Successfully Inserted into RavenDB (ID: $res_id)</div>
.Redirecting in 2 second to Login Section.....<img src='loader.gif'><br><br>";


echo "<script>
alert('Data Successfully Inserted into RavenDB');
window.setTimeout(function() {
    window.location.href = 'login.php';
}, 3000);
</script><br><br>";



}




}

curl_close($ch);


}  // endfile uploads




}else{

echo "<div style='background:red;color:white;padding:10px;border:none;'>Direct Page Access Not Allowed</div><br>";


}




?>



