<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession_intermediate'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM users WHERE user_id=".$_SESSION['userSession_intermediate']);
$userRow=$query->fetch_array();
$DBcon->close();

?>

	
<!-- Face Detection code block -->

<?php
ini_set('max_execution_time','200');
ini_set('display_errors',1);
error_reporting(E_ALL ^ E_NOTICE);
include "FaceDetector.php";
 
/* We now extend the above class so we can add our own methods */
class FaceModify extends Face_Detector {
 
  public function Rotate() {
    $canvas = imagecreatetruecolor($this->face['w'], $this->face['w']);
    imagecopy($canvas, $this->canvas, 0, 0, $this->face['x'], 
              $this->face['x'], $this->face['w'], $this->face['w']);
    $canvas = imagerotate($canvas, 180, 0);
    $this->_outImage($canvas);
  }
 
  public function toGrayScale() {
    $canvas = imagecreatetruecolor($this->face['w'], $this->face['w']);
    imagecopy($canvas, $this->canvas, 0, 0, $this->face['x'], 
              $this->face['x'], $this->face['w'], $this->face['w']);
    imagefilter ($canvas, IMG_FILTER_GRAYSCALE);
    $this->_outImage($canvas);
  }
 
  public function resizeFace($width, $height) {
    $canvas = imagecreatetruecolor($width, $width);
    imagecopyresized($canvas, $this->canvas, 0, 0, $this->face['x'], 
                     $this->face['y'], $width, $height, 
                     $this->face['w'], $this->face['w']);
    $this->_outImage($canvas);
  }

 public function saveCropedFace($path) {
$canvas = imagecreatetruecolor($this->face[‘w’], $this->face[‘w’]);
imagecopy($canvas, $this->canvas, 0, 0, $this->face[‘x’], $this->face[‘x’], $this->face[‘w’], $this->face[‘w’]);
//header(‘Content-type: image/jpeg’);
imagejpeg($canvas, $path);
}
	
  private function _outImage($canvas) {
    header('Content-type: image/jpeg');
    imagejpeg($canvas);
  }
}
 
/* Using the extended class */

/*  
$face_detect = new FaceModify('detection.dat');
$face_detect->face_detect($_GET['image']);
//$face_detect->resizeFace(100,100);

$face_detect->toJpeg(); //Returns the entire image but draws a rectangle around the detected face
//$face_detect->cropFace(); // Crops the picture to the detected face only
//$face_detect->toJson(); // Return coordinates of just the face in JSON
//$face_detect->getFace(); // Return coordinates as an Array e.g. {'x':56.375, 'y':45.1, 'w':227.55}
*/
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>faceOauth | A Face Authentication System for Online Proctored Examinations.</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="css/style.css" type="text/css" />
	<style>
		.flex-container {
		  display: flex;
		  justify-content: center;
    overflow: auto;
    height: 100vh;
    height: calc(100vh - 100px);
    position: relative;
    backface-visibility: hidden;
    will-change: overflow;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: none;
		}
		
		
		
		.footer {
	left: 0;
    bottom: 0;
    width: 100%;
	padding: 10px;
    background-color: #3B3A45;
    color: white;
    text-align: center;
}
	
	</style>
	
	
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script> <!--Required for the automatic snapping to work -->
</head>
<body style="background:#e8e8e8">

<div class="container" style="text-align:center; background: #f9f9f9">

		<div class="navbar" style="background: #120D3B;">
			
		<a href="get_started.php" style="font-size: 30px; color: white; text-decoration: none; float: left; margin-left: 10px">face<span style="color: #5023B0">Oauth</span></a>
          <ul class="nav navbar-nav">
				<li><a style="color: white; text-decoration: none" href="about.php">About</a></li>
				<li><a style="color: white; text-decoration: none" href="how_it_works.php">How it works</a></li>
			 <a style="float: right"  href="https://github.com/mogbolahan/faceOauth"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/a6677b08c955af8400f44c6298f40e7d19cc5b2d/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677261795f3664366436642e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png"></a>
			  <li><a style="color: white; text-decoration: none; float: right" href="logout.php">Logout</a></a>
          </ul>
        </div>
     <br>

<div style="padding-top:20px;"  class="flex-container">
     
	<div id="login_form" style="margin: 20px; width: 70%">  
       <h2>This is the Actual Exam window </h2>
		<h2>or perhaps, the home page of the user after his/her identity has been fully verified</h2>
    </div>
	
	
	<div id="admin_form"  style="margin: 20px;">
		<h3 style="color: dimgrey">To see the captured images for each user, logout, then login as an <b>admin</b> </h3>
      
    </div> 
	
	
	</div>
	
		
	<div class="footer">
	  <p>Mogbolahan Ojeyinka &nbsp;&nbsp;&nbsp;&nbsp;  | &nbsp;&nbsp;&nbsp;&nbsp;Supervised by:    Dr. Linqiang Ge</p>
	  <p>Department of Computer Science &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; Georgia Southwestern State University</p>
	
            <p>&copy; 2018 All rights reserved.</p>
</div>
	</div>
</div>



<!-- capture frame popup style -->
<style>
	.samll_cam_frame {
  background: #fff;
  width: 200px;
  height: 300px;
  position: fixed;
  bottom: -120px;
  right: 10px;
  transition: all .3s;
  border: 1px solid transparent;
  border-radius: 3px 3px 0 0;
  -webkit-box-shadow: rgba(0, 0, 0, 0.0980392) 0 0 1px 2px;
  -moz-box-shadow: rgba(0, 0, 0, 0.0980392) 0 0 1px 2px;
  box-shadow: rgba(0, 0, 0, 0.0980392) 0 0 1px 2px;
  overflow: hidden;
  z-index:1000000;
}

.samll_cam_frame_header {
  margin: 0 auto;
  padding: 0 10px;
  height: 20px;
  line-height: 20px;
  font-size: 15px;
  font-weight: 500;
  text-align: center;
  display: block;
  cursor: pointer;
  background: #051436;
  border: 1px solid #051436;
  color:#FFF;
}


</style>
	<!-- Small cam frame at th bottom right script-->
<div class="samll_cam_frame" id="samll_cam_frame">
  <div class="samll_cam_frame_header">Webcam</div>
	
	   <div id="web_cam"></div>
			
			<!--div id="web_cam"></div-->

			<!-- Webcam.js JavaScript Library -->
			<script type="text/javascript" src="js/webcam.js"></script>

			<!-- Configuring and attaching the camera -->
			<script language="JavaScript">
				Webcam.set({
					width: 200,
					height: 154,
					image_format: 'jpeg',
					jpeg_quality: 90
				});
				Webcam.attach( '#web_cam' );
			</script>


		<!-- Script for taking snaps and saving it on the server/ database

		My concens here is the choice of storage.
		Should the images be saved locally on a directory or on a database. ....Here comes the question of staorage.

		-->

		<script>
			(function($) {

			   function take_snapshot() {
						// take snapshot and get image data
						Webcam.snap( function(data_uri) {
							// display results in page


							Webcam.upload( data_uri, 'upload_image.php');	
						} );
					}

				$(document).ready(function(){
					window.setInterval(take_snapshot, 15000); // call our function every 15 seconds
				});

			})(jQuery);
		</script>
</div>

</body>
</html>

