<!DOCTYPE html>
<html lang="en" ng-app="wedding">
<head>
	<meta charset="UTF-8">
	<title>Confirmation - Tasnim &amp; Atib</title>
	<meta name="robots" content="noindex" />
	<meta name="robots" content="nofollow" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
	<link rel="shortcut icon" href="assets/images/favicon.png" size="16x16">

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
		

		<!-- <div class="row">
			<div class="col-sm-12">
				<h2> <a href="/">Tasnim &amp; Atib</a></h2>
			</div>
		</div> -->

<?php
error_reporting(E_ALL & ~E_NOTICE);
 
if(isset($_POST['email'])) {
 
     
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "hello@tasnimandatib.co.uk";
 
    $email_subject = "New question";
 
     
 
     
 
    function died($error) {
 
        // your error code can go here
 				
 				echo '<div class="row"><div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3"><div class="row sectionBackground"><div class="col-xs-12"><div class="row">
          <div class="col-sm-12">
            <p class="p_logo_top">
              <a href="/" class="logo">
                T&amp;A
              </a>
            </p>
          </div>
        </div><div class="row" ><div class="col-sm-12" ><h3> Errors </h3> <p> ';
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please <a class='emailrsvp_link' href='/#/rsvp'>go back</a> and fix these errors.<br /><br />";
 				
 				echo '</p></div></div><div class="row"><div class="col-sm-12"><div id="instafeed"></div></div></div></div></div></div></div><p class="p_logo"><a href="../" class="logo">T&amp;A</a></p><p class="credit">Designed &amp; Developed by <a href="https://atib.github.io">Atib</a></p></div>';

        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['name']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['message'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
    
    //Main Guest
 
    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['message']; // not required

    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
 
    $error_message .= 'The <b>Name</b> you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($comments) < 5) {
 
    $error_message .= 'Please enter <b>more than five characters</b>.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Details of the new question: .\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href", "string:");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Name: ".clean_string($name)."\n\n";
  
    $email_message .= "Email: \n".clean_string($email_from)."\n\n";
  		
    $email_message .= "Message: \n".clean_string($comments)."\n";
 
     
 
     
 
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
						<div class="row">
              <div class="col-sm-12">
                <p class="p_logo_top">
                  <a ui-sref="index" ui-sref-active="home" class="logo">
                    T&amp;A
                  </a>
                </p>
              </div>
            </div>
						<div class="row" >
							<div class="col-sm-12" >
								<h3>
									Thank You!
								</h3>
								<p> We will get back to you as soon as possible.<br>Have a wonderful day! </p>
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
			<a href="/" class="logo">
			  T&amp;A
			</a>
		</p>
		<p class="credit">
      Copyright &copy; 2016<br>
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


