<?php
//error_reporting(0); 
?>



<?php
session_start();
include ('authenticate.php');
include ('settings.php');

$userid_sess =  htmlentities(htmlentities($_SESSION['uid'], ENT_QUOTES, "UTF-8"));
$fullname_sess =  htmlentities(htmlentities($_SESSION['fullname'], ENT_QUOTES, "UTF-8"));
$username_sess =   htmlentities(htmlentities($_SESSION['username'], ENT_QUOTES, "UTF-8"));
$photo_sess =  htmlentities(htmlentities($_SESSION['photo'], ENT_QUOTES, "UTF-8"));
$email_sess =  htmlentities(htmlentities($_SESSION['email'], ENT_QUOTES, "UTF-8"));


// allow only allow alphanumeric strings, underscores and hyphen characters

$pageid = strip_tags($_GET['car_id']);


if(preg_match('/[^a-z_\-0-9]/i', $pageid))
{
  echo "<div style='color:white;background:red;padding:8px;border:none;'>Ilegal or invalid Characters on Cars page not allowed...</div>";
exit();
}



?>
<?php include('header_title.php') ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

<title> Welcome <?php echo htmlentities(htmlentities($_SESSION['fullname'], ENT_QUOTES, "UTF-8")); ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="" />






   <link rel="stylesheet" href="javascript/bootstrap.min.css">
    <script src="javascript/jquery.min.js"></script>
    <script src="javascript/bootstrap.min.js"></script>
    <script src="javascript/moment.js"></script>
    <script src="javascript/livestamp.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="css/style.css">
    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>


<script>

// stopt all bootstrap drop down menu from closing on click inside
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});


</script>





</head>

<body>
<!-- start column nav-->


<div class="text-center">




<!-- start column nav-->


<div class="text-center">
<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navgator">
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span> 
        <span class="navbar-header-collapse-color icon-bar"></span>                       
      </button>
     
<li class="navbar-brand home_click imagelogo_li_remove" ><img class="img-rounded imagelogo_data" src="logo1.png"></li>
    </div>
    <div class="collapse navbar-collapse" id="navgator">


      <ul class="nav navbar-nav navbar-right">


 <li class="navgate_no"><a title='Back To Dashboard' href="dashboard.php" style="color:white;font-size:14px;">
<button class="category_post1">Back To Dashboard</button></a></li>




 <li class="navgate_no"><a title='My Products' href="profile_base.php" style="color:white;font-size:14px;">
<button class="category_post1">My Products</button></a></li>

 <li class="navgate_no"><a title='Logout' href="logout.php" style="color:white;font-size:14px;">
<button class="category_post1">Logout</button></a></li>


             
<li class="navgate"><img style="max-height:60px;max-width:60px;" class="img-circle" width="60px" height="60px" src="uploads/<?php echo htmlentities(htmlentities($_SESSION['photo'], ENT_QUOTES, "UTF-8")); ?>" width="80px" height="80px">


<span class="dropdown">
  <a style="color:white;font-size:14px;cursor:pointer;" title='View More Data' class="btn1 btn-default1 dropdown-toggle"  data-toggle="dropdown"><?php echo htmlentities(htmlentities($_SESSION['fullname'], ENT_QUOTES, "UTF-8")); ?>
  <span class="caret"></span></a>

<ul class="dropdown-menu col-sm-12">
<li><a title='My Products' href="profile_base.php">My Products</a></li>
<li><a title='Logout' href="logout.php">Logout</a></li>

</ul></span>

</li>



      </ul>




    </div>
  </div>



</nav>


    </div><br /><br />

<!-- end column nav-->




    </div><br /><br />

<!-- end column nav-->

<h3><center > <b style='color:#800000'>Car Lenders Category: <?php echo $pageid; ?></b></center></h3>





<script>

// post like starts




$(document).ready(function(){

 $(".plike_btn").click(function(){



     var post_id = this.id; 
     var id = post_id;
//alert(id);

if(id == ''){
alert('Post Id cannot be empty');
return false;
}
        // AJAX Request


$("#loader-plike_"+id).fadeIn(400).html('<div style="color:black;background:#ccc;padding:10px;"><img src="loader.gif">&nbsp;Item Liking in Progress.</div>');

$("#loader2-plike_"+id).fadeIn(400).html('<div style="color:black;background:#ccc;padding:10px;"><img src="loader.gif"></div>');

        $.ajax({
            url: 'products_like.php',
            type: 'post',
            data: {post_id:post_id},
            dataType: 'json',
            success: function(data){

var msg = data['msg'];
if(msg=='like_already'){
alert('You Already Like This Products/Items');
$("#loader-plike_"+id).hide();
$("#loader2-plike_"+id).hide();
}

if(msg=='curl_error'){
alert(data['msg2']);
$("#loader-rating_"+id).hide();
$("#loader2-rating_"+id).hide();
}


if(msg=='success'){

                var like = data['like'];
               
$("#plike_total_"+id).text(like);


alert('Item Successfully Liked...');

$("#loader-plike_"+id).hide();
$("#loader2-plike_"+id).hide();
}



            }
        });

    });
});

// post like ends










// post unlike starts




$(document).ready(function(){

 $(".punlike_btn").click(function(){



     var post_id = this.id; 
     var id = post_id;
//alert(id);

if(id == ''){
alert('Post Id cannot be empty');
return false;
}
        // AJAX Request


$("#loader-punlike_"+id).fadeIn(400).html('<div style="color:black;background:#ccc;padding:10px;"><img src="loader.gif">&nbsp;Item UnLiking in Progress.</div>');

$("#loader2-punlike_"+id).fadeIn(400).html('<div style="color:black;background:#ccc;padding:10px;"><img src="loader.gif"></div>');

        $.ajax({
            url: 'products_unlike.php',
            type: 'post',
            data: {post_id:post_id},
            dataType: 'json',
            success: function(data){

var msg = data['msg'];
if(msg=='unlike_already'){
alert('You Already UnLike This Products/Items');
$("#loader-punlike_"+id).hide();
$("#loader2-punlike_"+id).hide();
}


if(msg=='curl_error'){
alert(data['msg2']);
$("#loader-rating_"+id).hide();
$("#loader2-rating_"+id).hide();
}

if(msg=='success'){

                var unlike = data['unlike'];
               
$("#punlike_total_"+id).text(unlike);


alert('Item Successfully UnLiked...');

$("#loader-punlike_"+id).hide();
$("#loader2-punlike_"+id).hide();
}



            }
        });

    });
});

// post unlike ends








// post rating starts




$(document).ready(function(){

 $(".rating_btn").click(function(){

 var pid = this.id;
 var split_id = pid.split("_");

		var rating = split_id[1]; 
						
						
     var post_id = split_id[0]; 
     var id = post_id;
//alert(id);
//alert(rating);

if(id == ''){
alert('Post Id cannot be empty');
return false;
}
        // AJAX Request


$("#loader-rating_"+id).fadeIn(400).html('<div style="color:black;background:#ccc;padding:10px;"><img src="loader.gif">&nbsp;Item Rating in Progress.</div>');

$("#loader2-rating_"+id).fadeIn(400).html('<div style="color:black;background:#ccc;padding:10px;"><img src="loader.gif"></div>');

        $.ajax({
            url: 'products_rating.php',
            type: 'post',
            data: {post_id:post_id, rating:rating},
            dataType: 'json',
            success: function(data){

var msg = data['msg'];
if(msg=='rating_already'){
alert('You Already Rated This Products/Items');
$("#loader-rating_"+id).hide();
$("#loader2-rating_"+id).hide();
}

if(msg=='curl_error'){
alert(data['msg2']);
$("#loader-rating_"+id).hide();
$("#loader2-rating_"+id).hide();
}


if(msg=='internet_error'){
alert(data['msg2']);
$("#loader-rating_"+id).hide();
$("#loader2-rating_"+id).hide();
}




if(msg=='success'){

                var rating = data['rating'];
               
$(".rating_total_"+id).text(rating);


alert('Item Successfully Rated...');

$("#loader-rating_"+id).hide();
$("#loader2-rating_"+id).hide();
}



            }
        });

    });
});

// post rating ends




</script>








<div class='row'>

<div class='col-sm-1'>
</div>

<div class='col-sm-10'>

<p>


<!--start posts-->

<div class="container">

<?php

$ch2 = curl_init();
$url2 ="$ravendb_database_url/databases/$ravendb_database_name/queries";
curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch2, CURLOPT_POSTFIELDS, "{ \n    \"Query\":\"from $product_tb where category = '$pageid'\" \n}");
//curl_setopt($ch2, CURLOPT_POSTFIELDS, "{ \n    \"Query\":\"from $product_tb\" \n}");

$headers2 = array();
$headers2[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
$result2 = curl_exec($ch2);

$json2 = json_decode($result2, true);
$TotalResults = $json2['TotalResults'];
$http_status2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

$totalcount = $TotalResults;




if (curl_errno($ch2)) {
   $curl_error2 = curl_error($ch2);
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Curl Requet Error: $curl_error2</div><br>";
}


if($result2 ==''){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Please Ensure there is Internet Connection and Try Again...</div><br>";
exit();
}



if($TotalResults == 0){
echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>No Products or Car Publish Yet for <b>($pageid)</b> CarLending Category </div>";

}


if($http_status2 ==200){
//echo "<div class='alerts_fades' style='background:green;color:white;padding:10px;border:none;'>API Call Successfully Made...</div><br>";
}



curl_close($ch2);


foreach ($json2['Results'] as $row){

$id= $row['product_id'];
                $postid = $row['product_id'];
                $title = htmlentities(htmlentities($row['title'], ENT_QUOTES, "UTF-8"));
                $description = htmlentities(htmlentities($row['detail'], ENT_QUOTES, "UTF-8"));
                $description_html = $row['detail_html'];
                $title_seo = htmlentities(htmlentities($row['title_seo'], ENT_QUOTES, "UTF-8"));
                $timing = htmlentities(htmlentities($row['product_id'], ENT_QUOTES, "UTF-8"));
                $username = htmlentities(htmlentities($row['userid'], ENT_QUOTES, "UTF-8"));
                $fullname =htmlentities(htmlentities($row['fullname'], ENT_QUOTES, "UTF-8"));
                $photo = htmlentities(htmlentities($row['user_photo'], ENT_QUOTES, "UTF-8"));
                $userid = htmlentities(htmlentities($row['userid'], ENT_QUOTES, "UTF-8"));
$category = htmlentities(htmlentities($row['category'], ENT_QUOTES, "UTF-8"));
$total_comments = htmlentities(htmlentities($row['total_comments'], ENT_QUOTES, "UTF-8")); 
$total_likes = htmlentities(htmlentities($row['total_likes'], ENT_QUOTES, "UTF-8")); 
$total_unlikes = htmlentities(htmlentities($row['total_unlikes'], ENT_QUOTES, "UTF-8")); 
$total_rate = htmlentities(htmlentities($row['total_rate'], ENT_QUOTES, "UTF-8")); 
//$total_views = htmlentities(htmlentities($row['total_views'], ENT_QUOTES, "UTF-8"));
$images = htmlentities(htmlentities($row['image'], ENT_QUOTES, "UTF-8"));      
$microcontent = substr($description, 0, 100)."...";  
$title_micro = substr($title, 0, 27)."...";  
$country = htmlentities(htmlentities($row['country'], ENT_QUOTES, "UTF-8"));
$country_code = htmlentities(htmlentities($row['country_iso'], ENT_QUOTES, "UTF-8"));  
$status = htmlentities(htmlentities($row['status'], ENT_QUOTES, "UTF-8")); 
$paypal_email = htmlentities(htmlentities($row['paypal_email'], ENT_QUOTES, "UTF-8"));
$email = htmlentities(htmlentities($row['email'], ENT_QUOTES, "UTF-8"));
$price = htmlentities(htmlentities($row['price'], ENT_QUOTES, "UTF-8"));
$changevector = $row['@metadata']['@change-vector'];
$city = htmlentities(htmlentities($row['city'], ENT_QUOTES, "UTF-8"));
$state = htmlentities(htmlentities($row['state'], ENT_QUOTES, "UTF-8"));


//}










if($status == 'Active'){

$fx ="green_css";
$fs = "Post Approved";
}else{

$fx ="red_css";
$fs = "Post Pending Approval";

}



            ?>

                <div class='post col-sm-12 well'  style='display:inline-blockx;' id="post_<?php echo $id; ?>">

<?php
if($title){
?>

<img class='' style='border-style: solid; border-width:3px; border-color:#8B008B; width:50px;height:50px; 
max-width:50px;max-height:50px;border-radius: 50%;' src='uploads/<?php echo $photo; ?>' title='Image'>
<b style='color:#8B008B;font-size:14px;' >Owner: <?php echo $fullname; ?> </b><br>
<b style='font-size:12px;' class='<?php echo $fx; ?>' >Post Status: <?php echo $fs; ?> </b><br>


<div class='row'>
<div class='col-sm-3'>
<img class='pull-right img-rounded' style='border-style: solid; border-width:3px; border-color:#8B008B; width:200px;height:200px; 
max-width:200px;max-height:200px; min-width:200px;min-height:200px;' src='images/<?php echo $images; ?>' title='<?php echo $title; ?>' alt='<?php echo $title; ?>'>
<br>

<div title='View Poster Profile for More Content' class='col-sm-12 time_css2' style='color:#824c4e;'>  <a  style="color:#8B008B;" href="profile_user.php?userid=<?php echo $userid;?>&identity=<?php echo $username;?>">
View Poster Profile for More Content &nbsp;&nbsp;<i  style='display:none;color:#824c4e;font-size:30px;' class='fa fa-user'></i></a></div><br>

<br>

</div>
    
<div class='col-sm-9'>
<p class='title_css'></p><h3>Title:</b>  <?php echo $title; ?></h3>
<b>Category:</b> <?php echo $category; ?><br>
<b>Descriptions:</b> <?php echo $microcontent; ?><br>

<b>Car Lending Price:</b> <span class='time_css2'><?php echo $price; ?> (USD)</span><br>
<b>Locations/Country:</b> <?php echo $country; ?><br>
<b>State:</b> <?php echo $state; ?><br>
<b>City:</b> <?php echo $city; ?><br>

<b>Descriptions Details:</b> <?php echo $description_html; ?><br>

<span><b> <span style='color:#8B008B;' class='fa fa-calendar'></span>Created:</b>  <span data-livestamp="<?php echo $timing;?>"></span></span>
<br>
<br>


<!--start p-->
<div class-'row'>
<div class='col-sm-2 time_css2x'>

<span>
<span id="loader-plike_<?php echo $postid; ?>"></span>
<span style="font-size:26px;color:#800000;cursor:pointer;" class="plike_btn fa fa-thumbs-up time_css2" id="<?php echo $postid; ?>" title="Like">
&nbsp;<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
<span style='font-size:14px'>(<span id="plike_total_<?php echo $postid; ?>"><?php echo $total_likes; ?></span>)</span>
</span> 

<span id="loader-plike_no_<?php echo $postid; ?>"></span>
</span>


</div>


<div class='col-sm-2 time_css2x'>
<span>
<span id="loader-punlike_<?php echo $postid; ?>"></span>
<span style="font-size:26px;color:#800000;cursor:pointer;" class="punlike_btn fa fa-thumbs-down time_css2" id="<?php echo $postid; ?>" title="UnLike">
&nbsp;<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
<span style='font-size:14px'>(<span id="punlike_total_<?php echo $postid; ?>"><?php echo $total_unlikes; ?></span>)</span>
</span> 

<span id="loader-punlike_no_<?php echo $postid; ?>"></span>
</span>



</div>



<style>
.rt_css{
//background-color: #800000;
//font-size:20px;
//cursor:pointer;
}
.rt_css:hover {
background: grey;
}
</style>

<div class='col-sm-3 time_css2x'>
<p></p>
<p>
<span>
<span id="loader-rating_<?php echo $postid; ?>"></span>
<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_1" title="1 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000x;" /></span>
</span> 

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_2" title="2 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_3" title="3 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_4" title="4 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_5" title="5 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style='font-size:14px'>(<span class="rating_total_<?php echo $postid; ?>"><?php echo $total_rate; ?></span>)</span>
</p>

</span>



</div>







<div class='col-sm-2 time_css2x'>

<span>

<span style="font-size:26px;color:#800000;cursor:pointer;" class="comments_btn fa fa-comment time_css2" id="<?php echo $postid; ?>" title="Comments">
&nbsp;<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
<span style='font-size:14px'>(<span id="pcomment_total_<?php echo $postid; ?>"><?php echo $total_comments; ?></span>)</span>
</span> 


<span id="loader-pcomments_no_<?php echo $postid; ?>"></span>
</span>


</div>










<div class='col-sm-2 time_css2x'>
<span style='color:#824c4e;'>  Pay Via Paypal</span>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target='_blank'>
 <!-- Identify your business so that you can collect the payments. --> 
<input type="hidden" name="business" value="<?php echo $paypal_email; ?>"> <!-- Specify a Buy Now button. --> 
<input type="hidden" name="cmd" value="_xclick"> <!-- Specify details about the item that buyers will purchase. -->
 <input type="hidden" name="item_name" value="<?php echo $title; ?>"> 
<input type="hidden" name="amount" value="<?php echo $price; ?>"> 
<input type="hidden" name="currency_code" value="USD"> <!-- Provide a drop-down menu option field. --> 

 <!-- Display the payment button. --> 
<input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="Buy Now" title="Pay Via Paypal"> 
<img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
 </form>


</div>






<div class='col-sm-4 time_css2x'><p>Share:





<a target='_blank' href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $site_url; ?>/share.php?title=<?php echo $title_seo; ?>&quote=<?php echo $title; ?>">
<i class="fa fa-facebook pshare_btn"  id="<?php echo $postid; ?>" aria-hidden="true" title="Facebook" style="font-size:26px;color:#3b5998;cursor:pointer;"></i>
</a>
&nbsp;

<a  target='_blank' href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&url=<?php echo $site_url; ?>/share.php?title=<?php echo $title_seo; ?>">
<i class="fa fa-twitter pshare_btn"  id="<?php echo $postid; ?>" aria-hidden="true" title="Twitter" style="font-size:26px;color:#0b7dda;cursor:pointer;">
</i></a>
&nbsp;

<a  target='_blank' href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $site_url; ?>/share.php?title=<?php echo $title_seo; ?>">
<i class="fa fa-linkedin pshare_btn"  id="<?php echo $postid; ?>" aria-hidden="true"  title="LinkedIn" style="font-size:26px;color:#2196F3;cursor:pointer;"></i>
</a>
&nbsp;

<a style='display:none;' target='_blank' href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $site_url; ?>/share.php?title=<?php echo $title_seo; ?>&caption=<?php echo $title; ?>&tags=<?php echo $title; ?>">
<i class="fa fa-tumblr pshare_btn"  id="<?php echo $postid; ?>" aria-hidden="true" title="Tumblr" style="font-size:26px;color:#da190b;cursor:pointer;"></i>
</a>
&nbsp;
<a target='_blank' href="https://t.me/share/url?url=<?php echo $site_url; ?>/share.php?title=<?php echo $title_seo; ?>&text=<?php echo $title; ?>">
<i class="fa fa-telegram pshare_btn"  id="<?php echo $postid; ?>" aria-hidden="true" title="Telegram" style="font-size:26px;color:#0088cc;cursor:pointer;"></i>
</a>
&nbsp;
<a  target='_blank' href="https://wa.me/?text=<?php echo $site_url; ?>/share.php?title=<?php echo $title_seo; ?>">
<i class="fa fa-whatsapp pshare_btn"  id="<?php echo $postid; ?>" aria-hidden="true" title="Whatsapp" style="font-size:26px;color:#075E54;cursor:pointer;"></i>
</a>

</a>


</div>

</div>

<!--end p-->



</div>
</div>



<?php } ?>













                   
                </div>

            <?php
            }
            ?>


        </div>

<!--end posts-->




</p>


</div>


<div class='col-sm-1'>
</div>



</div>









<!-- footer Section start -->

<footer class=" navbar_footer text-center footer_bgcolor">

<div class="row">
        <div class="col-sm-12">

<p class="footer_text1"><?php echo $header_tit; ?></p>
<p class="footer_text2"><?php include('footer_title.php'); echo $footer_tit1; ?></p>

        </div>



        </div>

</footer>

<!-- footer Section ends -->






</body>
</html>