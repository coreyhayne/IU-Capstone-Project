<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="726609449658-g6s5m9hit9pjgpg5h7o5s2ov9n6at041.apps.googleusercontent.com" >
    <title>Create User Profile</title>
    <link rel="shortcut icon" type="images/png" href="images/favicon.ico"/>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://assets.uits.iu.edu/css/rivet/1.7.2/rivet.min.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<!-- HEADER -->
    <!-- ======================================================================================================================== -->
<body>
        <header class="rvt-header" role="banner">
            <a class="rvt-skip-link" href="#main-content">Skip to content</a>
            <!-- Trident -->
            <div class="rvt-header__trident">
                <svg class="rvt-header__trident-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 41 48"
                    aria-hidden="true">
                    <title id="iu-logo">Indiana University Logo</title>
                    <rect width="41" height="58" fill="#900" />
                    <polygon
                        points="24.59 12.64 24.59 14.98 26.34 14.98 26.34 27.78 22.84 27.78 22.84 10.9 24.59 10.9 24.59 8.57 16.41 8.57 16.41 10.9 18.16 10.9 18.16 27.78 14.66 27.78 14.66 14.98 16.41 14.98 16.41 12.64 8.22 12.64 8.22 14.98 9.97 14.98 9.97 30.03 12.77 33.02 18.16 33.02 18.16 36.52 16.41 36.52 16.41 39.43 24.59 39.43 24.59 36.52 22.84 36.52 22.84 33.02 28 33.02 31.01 30.03 31.01 14.98 32.78 14.98 32.78 12.64 24.59 12.64"
                        fill="#fff" />
                </svg>
            </div>
            <!-- App title -->
            <span class="rvt-header__title">
                UniLife
            </span>
    </header>


<div class="all-body-container">
	<div class="rvt-flex rvt-wrap">
		<div class="rvt-middle-body rvt-grow-1 rvt-m-right-sm">
			<div class="rvt-box rvt-box--card">
                		<div class="rvt-box__body">
					<div class="rvt-container">
						<form method="POST">
						<p style="font-size:20px;"><b>First Name:</b> <input style="width:350px;" type="text" class="form-input" name="form-fname" required></p>
     						<p style="font-size:20px;"><b>Last Name:</b> <input style="width:350px;" type="text" class="form-input" name="form-lname" required></p>
						<p style="font-size:20px;"><b>Bio:</b> <textarea style="width:600px; height:200px;" resize:none;" class="form-input" name="form-bio" rows="10" cols="30"></textarea></p>							
					</div>
				</div>
			</div>
			<div class="rvt-box rvt-box--card">
                                <div class="rvt-box__body">
                                        <div class="rvt-container">
						<p style="font-size:30px; text-align:center; color:#990000;"><b>Personal Information</b></p>
						<div class="rvt-grid">
							<p style="font-size:20px;"><b>Class:</b><br>  <select style="width:350px;" class="rvt-button" name="form-class"><p>
	        					<option value="" disabled selected hidden>Choose Your Class</option>
							<option value=""></option>
            						<option value="Freshman" style="font-size:20px;">Freshman</option>
            						<option value="Sophomore" style="font-size:20px;">Sophomore</option>
            						<option value="Junior" style="font-size:20px;">Junior</option>
            						<option value="Senior" style="font-size:20px;">Senior</option>
            						<option value="Graduate" style="font-size:20px;">Graduate</option>
        						</select>
        					</div>
						<div class="rvt-grid">
							<p style="font-size:20px;"><b>Major:</b><br> <select style="width:350px;" class="rvt-button" name="form-major"></p>
		        				<option value="" disabled selected hidden>Choose Your Major</option>
							<option value=""></option>
        
                					<?php
                    						$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                    						// Check Connection
                    						if (!$con) {
                            						die("Connection failed: " . mysqli_connect_error() . "<br>");
                    						}
                        
                    						$result = mysqli_query($con, "SELECT degreeName from Degree WHERE degreeType = 'major';");
                    						while ($row = mysqli_fetch_assoc($result)) {
                        						$degrees = $row['degreeName'];
                        						echo '<option style="font-size:20px;" value="'.$degrees.'">'.$degrees.'</option>';
                    						}
                					?>
                
            						</select>
            					</div>
						<div class="rvt-grid">
							<p style="font-size:20px;"><b>Minor:</b><br> <select style="width:350px;" class="rvt-button" name="form-minor"></p>
					                <option value="" disabled selected hidden>Choose Your Minor</option>
                					<option value=""></option>

							<?php
                    						$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                    						// Check Connection
                    						if (!$con) {
                        						die("Connection failed: " . mysqli_connect_error() . "<br>");
                    						}
                    
                    						$result = mysqli_query($con, "SELECT degreeName from Degree WHERE degreeType='minor';");
                    						while ($row = mysqli_fetch_assoc($result)) {
                        						$degrees = $row['degreeName'];
                        						echo '<option  style="font-size:20px;" value="'.$degrees.'">'.$degrees.'</option>';
                    							}
                					?>   

            						</select>
            					</div>
						<div class="rvt-grid">
							<p class="p-form" style="font-size:20px;"><b>Phone:</b><br> <input style="width:350px;" type="text" class="form-input" name="form-phone"></p>
						</div>
					</div>
				</div>
			</div>
			 <div class="rvt-box rvt-box--card">
                                <div class="rvt-box__body">
                                        <div class="rvt-container">
                                                        <p style="font-size:30px; text-align:center; color:#990000;"><b>Student Information</b></p>
                                                
						<div class="user-row">
							<p style="font-size:20px; margin-left:-12px;" ><b>Current Courses: (CMD + Click to Select)</b>

               						 <?php
                        					$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                        					// Check Connection
                        					if (!$con) {
                            						die("Connection failed: " . mysqli_connect_error() . "<br>");
                        					}

                        					$result = mysqli_query($con, "SELECT courseName from Course;");
                        					echo '<select name="form-courses[]" multiple="multiple">';
                        					while ($row = mysqli_fetch_assoc($result)) {
                            						$courses = $row['courseName'];
                            						echo '<option style="font-size:20px;" value="'.$courses.'">'.$courses.'</option>';
                    						}
                        					echo '</select>';
                					?>
							</p>
                				</div>
						<div class="rvt-grid">
							<p style="font-size:20px;"><b>Interests: (CMD + Click to Select)</b>

							<?php
                     						$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                        					// Check Connection
                        					if (!$con) {
                            						die("Connection failed: " . mysqli_connect_error() . "<br>");
                        					}
                        					$result = mysqli_query($con, "SELECT interest from Interest;");
                        					echo '<select name="form-interests[]" multiple="multiple">';
                        					while ($row = mysqli_fetch_assoc($result)) {
                            						$interests = $row['interest'];
			    						$interestId = $row['interestId'];
                            						echo '<option style="font-size:20px;" value="'.$interests.'">'.$interests.'</option>';
                    						}
                     						echo '</select>';
                					?>
                					</p>
                				</div>  
					</div>
				</div>
			</div>
			<div class="rvt-box rvt-box--card">
                                <div class="rvt-box__body">
                                        <div class="rvt-container">
						<div class="rvt-grid">
            						<button  class="rvt-button">Submit</button>
	    					</div>
        					</form>
        					

        		<?php
		
            		$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
            		// Check Connection
            		if (!$con) {
                		die("Connection failed: " . mysqli_connect_error() . "<br>");
            		}
			
			$var_userId = $_SESSION['userId'];
			$var_email = $_SESSION['email'];			
            		$var_fname = mysqli_real_escape_string($con,trim($_POST['form-fname']));
            		$var_lname = mysqli_real_escape_string($con,trim($_POST['form-lname']));
            		$var_bio = mysqli_real_escape_string($con,trim($_POST['form-bio']));
            		$var_class = mysqli_real_escape_string($con,$_POST['form-class']); if(!isset($_POST['form-class'])) {$var_class = NULL;}
            		$var_phone = mysqli_real_escape_string($con,trim($_POST['form-phone']));
            		$var_courses = $_POST['form-courses'];
            		$var_interests = $_POST['form-interests']; 
            		$var_major = mysqli_real_escape_string($con,$_POST['form-major']); 
            		$var_minor = mysqli_real_escape_string($con,$_POST['form-minor']); 
			
			if ((!empty($var_fname)) && (!empty($var_lname))) {
            		$sql = "INSERT INTO User (userId, fname, lname, email, phone, biography, class,photo) VALUES ('$var_userId', '$var_fname','$var_lname','$var_email','$var_phone','$var_bio','$var_class',NULL);";
	    		mysqli_query($con,$sql);
			}
				    	
            		if (isset($var_major)) {
                		$sql1 = "INSERT INTO User_Degree (degreeId, userId) VALUES ((SELECT degreeId FROM Degree WHERE degreeName='$var_major' AND degreeType='Major'),(SELECT userId FROM User WHERE email='$var_email'));";
                		mysqli_query($con,$sql1);
			}
			
	   		if (isset($var_minor)) {
                		$sql2 = "INSERT INTO User_Degree (degreeId, userId) VALUES ((SELECT degreeId FROM Degree WHERE degreeName='$var_minor' AND degreeType='Minor'),(SELECT userId FROM User WHERE email='$var_email'));";
                		 mysqli_query($con,$sql2);
			}
			


	    		if(!empty($var_courses)) {
	        		$count = count($var_courses);
				for ($i=0; $i < $count; $i++) {
		    			$sql3 = "INSERT INTO User_Course (courseId,userId) VALUES ((SELECT courseId FROM Course WHERE courseName='$var_courses[$i]'),(SELECT userId FROM User WHERE email='$var_email'));";
               				mysqli_query($con,$sql3);
            			}
			}
			 if(!empty($var_interests)) {
                                $count = count($var_interests);
                                for ($i=0; $i < $count; $i++) {
                                        $sql4 = "INSERT INTO User_Interest (interestId,userId) VALUES ((SELECT interestId FROM Interest WHERE interest='$var_interests[$i]'),(SELECT userId FROM User WHERE email='$var_email'));";
                                        mysqli_query($con,$sql4);
                                }
			
			}
			if (isset($_POST['rvt-button'])) {		
                		header('location: /viewUser.php');;		
            		}
			$con->close();
        	?>
        
    
					
					
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
