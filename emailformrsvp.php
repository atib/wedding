<!DOCTYPE html>
<html lang="en" ng-app="wedding">
<head>
	<meta charset="UTF-8">
	<title>Confirmation - Tasnim &amp; Atib</title>
	<meta name="robots" content="noindex" />
	<meta name="robots" content="nofollow" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" size="16x16">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:100, 400" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cinzel:400" rel="stylesheet">	
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/scss/wedding.css">

</head>
<body>
	
	<div class="container-fluid">
		<div class="row">
	    <div class="col-xs-12">
	      <ul>  
	        <li><a href="/" >Home</a></li>
	      </ul>
	    </div>
	  </div>
		

		<div class="row">
			<div class="col-sm-12">
				<h2> <a href="/">Tasnim &amp; Atib</a></h2>
			</div>
		</div>

<?php
 
if(isset($_POST['email'])) {
 
     
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "rsvp@tasnimandatib.co.uk";
 
    $email_subject = "New wedding RSVP";
 
     
 
     
 
    function died($error) {
 
        // your error code can go here
 				
 				echo '<div class="row"><div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3"><div class="row sectionBackground"><div class="col-xs-12"><div class="row" ><div class="col-sm-12" ><h3> Errors </h3> <p> ';
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please <a class='emailrsvp_link' href='../#/rsvp'>go back</a> and fix these errors.<br /><br />";
 				
 				echo '</p></div></div><div class="row"><div class="col-sm-12"><div id="instafeed"></div></div></div></div></div></div></div><p class="p_logo"><a href="../" class="logo">T&amp;A</a></p><p class="credit">Designed &amp; Developed by <a href="https://atib.github.io">Atib</a></p></div>';

        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['firstname']) ||
 
        !isset($_POST['lastname']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['coming']) ||

        !isset($_POST['firstname_1']) ||
        !isset($_POST['lastname_1']) ||

        !isset($_POST['firstname_2']) ||
        !isset($_POST['lastname_2']) ||

        !isset($_POST['firstname_3']) ||
        !isset($_POST['lastname_3']) ||

        !isset($_POST['firstname_4']) ||
        !isset($_POST['lastname_4']) ||

        !isset($_POST['firstname_5']) ||
        !isset($_POST['lastname_5']) ||

        !isset($_POST['additonal_guests']) ||

        !isset($_POST['message'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
    
    //Main Guest
 
    $first_name = $_POST['firstname']; // required
	  $last_name = $_POST['lastname']; // required    
    $email_from = $_POST['email']; // required
		$coming = $_POST['coming']; // required
    $comments = $_POST['message']; // not required


	  // Additional Guests Names
    $firstname_1 = $_POST['firstname_1']; // not required
	  $lastname_1 = $_POST['lastname_1']; // not required

    $firstname_2 = $_POST['firstname_2']; // not required
	  $lastname_2 = $_POST['lastname_2']; // not required

    $firstname_3 = $_POST['firstname_3']; // not required
	  $lastname_3 = $_POST['lastname_3']; // not required

    $firstname_4 = $_POST['firstname_4']; // not required
	  $lastname_4 = $_POST['lastname_4']; // not required 

    $firstname_5 = $_POST['firstname_5']; // not required
    $lastname_5 = $_POST['lastname_5']; // not required 

    $additional = $_POST['additonal_guests']; // not required 

    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= 'The <b>First Name</b> you entered does not appear to be valid.<br />';
 
  }
 
  if(!preg_match($string_exp,$last_name)) {
 
    $error_message .= 'The <b>Last Name</b> you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($coming) < 2) {
 
    $error_message .= 'Please enter either <b>yes</b> or <b>no</b> whether you will be attending.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "The RSVP details for a new guest.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Main Guest Name: ".clean_string($first_name)." ".clean_string($last_name). "\n";
  
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Are they coming?: ".clean_string($coming)."\n";
 		
    $email_message .= "The additional guests are listed below \n";
    
    $email_message .= "Number of Additional Guests: ".clean_string($additional)." \n";

    $email_message .= "Additional Guest 1: ".clean_string($firstname_1)." ".clean_string($lastname_1). "\n";

    $email_message .= "Additional Guest 2: ".clean_string($firstname_2)." ".clean_string($lastname_2). "\n";
    
    $email_message .= "Additional Guest 3: ".clean_string($firstname_3)." ".clean_string($lastname_3). "\n";
    
    $email_message .= "Additional Guest 4: ".clean_string($firstname_4)." ".clean_string($lastname_4). "\n";

    $email_message .= "Additional Guest 5: ".clean_string($firstname_5)." ".clean_string($lastname_5). "\n";

    $email_message .= "Message: ".clean_string($comments)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);  
 
?>
 



		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
				<div class="row sectionBackground">
					<div class="col-xs-12">
						
						<div class="row" >
							<div class="col-sm-12" >
								<h3>
									Thank You!
								</h3>
								<p> Thank you for sending us your RSVP. We will send a confirmation email very soon. </p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div id="instafeed"></div>
							</div>
						</div>

						

					</div>
				</div>
			</div>
		</div>
		<p class="p_logo">
			<a href="../" class="logo">
			  T&amp;A
			</a>
		</p>
		<p class="credit">
			Designed &amp; Developed by <a href="https://atib.github.io">Atib</a>
		</p>
	</div>
	


	<script type="text/javascript" src="assets/js/dist/wedding.min.js"></script>
	<script type="text/javascript" src="assets/js/dist/instafeed.js"></script>
	<script type="text/javascript" src="app/app.js"></script>

</body>
</html>






 
 
 
<?php
 
}
 
?>


