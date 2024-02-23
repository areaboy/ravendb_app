<?php

// configuration
//error_reporting(0);
include('settings.php');


//$row = 0;
if(isset($_POST['row_limit'])){
    $row = strip_tags($_POST['row_limit']);
}


$rowpage = 2;
$start = $row;

$ch = curl_init();
$url ="$ravendb_database_url/databases/$ravendb_database_name/docs?startsWith=$product_tb&start=$start&pageSize=$rowpage";
//$url ="$ravendb_database_url/databases/$ravendb_database_name/docs?matches=$product_tb&start=$start&pageSize=$rowpage";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
//$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 $result = curl_exec($ch);

$json = json_decode($result, true);
//$res_id = $json['Id'];


$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//curl_close($ch);


if (curl_errno($ch)) {
   $curl_error = curl_error($ch);

echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Curl Request Error: $curl_error</div><br>";
}



if($result ==''){

echo "<div class='alerts_fades' style='background:red;color:white;padding:10px;border:none;'>Please Ensure there is Internet Connection and Try Again...</div><br>";
exit();
}



foreach ($json['Results'] as $row){

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




//curl_close($ch);






if($status == 'Active'){

$fx ="green_css";
$fs = "Post Approved";
}else{

$fx ="red_css";
$fs = "Post Pending Approval";

}

	
	 ?>

                <div style='display:inline-blockx;' class="post post_<?php echo $id; ?> col-sm-12 well" id="post_<?php echo $id; ?>">







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

<div title='View  Poster Profile for More Jobs' class='col-sm-12 time_css2' style='color:#824c4e;'>  <a  style="color:#8B008B;" href="profile_user.php?userid=<?php echo $userid;?>&identity=<?php echo $username;?>">
View Poster Profile for More Content &nbsp;&nbsp;<i  style='display:none;color:#824c4e;font-size:30px;' class='fa fa-user'></i></a></div><br>

<br>

</div>
    
<div class='col-sm-9'>
<p class='title_css'></p><h3> Title:</b>  <?php echo $title; ?></h3>
<b>Category:</b> <?php echo $category; ?><br>
<b>Descriptions:</b> <?php echo $microcontent; ?><br>
<b>Car Lending Price:</b> <span class='time_css2'><?php echo $price; ?> (USD)</span><br>
<b>Locations/Country:</b> <?php echo $country; ?><br>
<b>State:</b> <?php echo $state; ?><br>
<b>City:</b> <?php echo $city; ?><br>
<span><b> <span style='color:#8B008B;' class='fa fa-calendar'></span>Created:</b>  <span data-livestamp="<?php echo $timing;?>"></span></span>
<br>
<br>


<!--start p-->
<div class-'row'>
<div class='col-sm-2 time_css2x'>

<span>
<span id="loader-plike_<?php echo $postid; ?>"></span>
<span style="font-size:26px;color:#800000;cursor:pointer;" class="plike_btn2 fa fa-thumbs-up time_css2" id="<?php echo $postid; ?>" title="Like">
&nbsp;<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
<span style='font-size:14px'>(<span id="plike_total_<?php echo $postid; ?>"><?php echo $total_likes; ?></span>)</span>
</span> 

<span id="loader-plike_no_<?php echo $postid; ?>"></span>
</span>


</div>


<div class='col-sm-2 time_css2x'>
<span>
<span id="loader-punlike_<?php echo $postid; ?>"></span>
<span style="font-size:26px;color:#800000;cursor:pointer;" class="punlike_btn2 fa fa-thumbs-down time_css2" id="<?php echo $postid; ?>" title="UnLike">
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
<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn2 fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_1" title="1 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000x;" /></span>
</span> 

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn2 fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_2" title="2 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn2 fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_3" title="3 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn2 fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_4" title="4 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style="font-size:20px;color:#800000;cursor:pointer;" class="rating_btn2 fa fa-star time_css2no rt_css" id="<?php echo $postid; ?>_5" title="5 Star">
<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
</span>

<span style='font-size:14px'>(<span id="rating_total_<?php echo $postid; ?>"><?php echo $total_rate; ?></span>)</span>
</p>

</span>



</div>







<div class='col-sm-2 time_css2x'>

<span>
<a href='<?php echo $site_url; ?>/products_profile.php?pageid=<?php echo $title_seo;?>'>
<span style="font-size:26px;color:#800000;cursor:pointer;" class="comments_btn fa fa-comment time_css2" id="<?php echo $postid; ?>" title="Comments">
&nbsp; <span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
<span style='font-size:14px'>(<span id="pcomments_total_<?php echo $postid; ?>"><?php echo $total_comments; ?></span>)</span>


</span> </a>

<span id="loader-pcomments_<?php echo $postid; ?>"></span>
</span>


</div>










<div class='col-sm-2 time_css2x'>
<span style='color:#824c4e;'>  <a  title='View Details and Pay' style="color:#8B008B;" href="<?php echo $site_url; ?>/products_profile.php?pageid=<?php echo $title_seo;?>">
View Details & Pay<i  style='color:#824c4e;font-size:30px;' class=''></i></a></span>
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
	