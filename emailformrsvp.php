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

  $email_to = "rsvp@tasnimandatib.co.uk";

  $email_subject = "New wedding RSVP";

     
 
     
 
  function died($error) {

      // your error code can go here
				
				echo '<div class="row"><div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3"><div class="row sectionBackground"><div class="col-xs-12"><div class="row">
        <div class="col-sm-12">
          <p class="p_logo_top">
            <span class="logo">
              <a href="/">
               T&amp;A
              </a>
            </span>
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

  if(!isset($_POST['firstname']) ||
      !isset($_POST['lastname']) ||
      !isset($_POST['email']) || 
      !isset($_POST['coming']) || !isset($_POST['side']) ||
      !isset($_POST['message'])) {

      died('We are sorry, but there appears to be a problem with the form you submitted.');       

  }

  
  //Main Guest

  $first_name = $_POST['firstname']; // required
  $last_name = $_POST['lastname']; // required    
  $email_from = $_POST['email']; // required
	$coming = $_POST['coming']; // required
  $comments = $_POST['message']; // not required
  $side = $_POST['side']; // required

  // Additional Guests Names

  if (isset($_POST['firstname_1']) || isset($_POST['lastname_1']) || isset($_POST['firstname_2']) || isset($_POST['lastname_2']) || isset($_POST['firstname_3']) || isset($_POST['lastname_3']) || isset($_POST['firstname_4']) || isset($_POST['lastname_4']) || isset($_POST['firstname_5']) || isset($_POST['lastname_5']) || isset($_POST['add_guests'])) {

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

    $additional = $_POST['add_guests'];
  }
  
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
 
  //Email sent to RSVP email
  $email_message = "The RSVP details for a new guest.\n\n";
  
  //Email sent to guest
  $email_guest = "Your RSVP Details";
     
 
  function clean_string($string) {

    $bad = array("content-type","bcc:","to:","cc:","href", "string:");

    return str_replace($bad,"",$string);
  }
 
     
 
  $email_message .= "Main Guest Name: ".clean_string($first_name)." ".clean_string($last_name). "\n\n";
  
  $email_message .= "Email: \n".clean_string($email_from)."\n\n";

  $email_message .= "Which Side: ".clean_string($side)."\n\n";
 
  $email_message .= "Are they coming?: \n".clean_string($coming)."\n\n";
 		
  if (isset($_POST['firstname_1']) ||
        isset($_POST['lastname_1']) ||

        isset($_POST['firstname_2']) ||
        isset($_POST['lastname_2']) ||

        isset($_POST['firstname_3']) ||
        isset($_POST['lastname_3']) ||

        isset($_POST['firstname_4']) ||
        isset($_POST['lastname_4']) ||

        isset($_POST['firstname_5']) ||
        isset($_POST['lastname_5'])) {

          $email_message .= "The additional guests are listed below \n\n";

          $email_message .= "Number of Additional Guests: ".clean_string($additional)." \n\n";

          if($firstname_1) {
            $email_message .= "Additional Guest 1: \n".clean_string($firstname_1)." ".clean_string($lastname_1). "\n\n";
          }

          if($firstname_2){
            $email_message .= "Additional Guest 2: \n".clean_string($firstname_2)." ".clean_string($lastname_2). "\n\n";
          }

          if($firstname_3){
          $email_message .= "Additional Guest 3: \n".clean_string($firstname_3)." ".clean_string($lastname_3). "\n\n";

          }
          if($firstname_4){
          $email_message .= "Additional Guest 4: \n".clean_string($firstname_4)." ".clean_string($lastname_4). "\n\n";

          }
          if($firstname_5){
          $email_message .= "Additional Guest 5: \n".clean_string($firstname_5)." ".clean_string($lastname_5). "\n\n";

          }
  }
    
  $email_message .= "Message: \n".clean_string($comments)."\n";
 
     
  $guest_email = clean_string($email_from);
  if ($coming == 'Nope') {
    $guest_subject = 'We\'re going to miss you :\'(';
  } else {
    $guest_subject = 'Looking Forward to Seeing You! (Details Attached) ';

  }

  $message_guest = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml">
                       <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Wedding Invite</title>
                      </head>
                      <body style="margin:0; padding: 0; font-family: sans-serif; font-size: 14px;">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                            <tr>
                              <td bgcolor="#A9B7C0"">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="700">
                                  <tr>
                                    <td>
                                      <table align="center" border="0" cellpadding="0" cellspacing="0" width="80%" style="border-collapse: collapse;">
                                        <tr>
                                          <td bgcolor="#F3EEEE" height="300" align="center">
                                            <span style=" color: transparent; border: 7px solid #CFAE88; padding: 71px 26px 53px; font-family: serif; text-decoration: none;">
                                              <p style=" display: inline-block; padding: 0; margin: 0; color: #525252; font-size: 46px; font-weight: 100; z-index: 1000;text-transform: uppercase; letter-spacing: -1px;" >
                                                T&amp;A
                                              </p>
                                            </span>
                                          </td>
                                        </tr>';
  
  if ($coming == 'Nope') {
    $message_guest .= '<tr>
                  <td bgcolor="#FFFFFF" style="padding: 20px 10px;" align="left">
                   <p style="font-family: sans-serif; text-transform: capitalize; font-size: 14px; font-weight: lighter; letter-spacing: 1.5px;">Hi '.$first_name.'</p>
                   <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px;">Thank you for letting us know you would not be able to attend.</p>
                    <br />
                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px; margin: 0; padding-top: 10px; font-weight: lighter;">Best Wishes,
                    </p>
                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1.5px; margin: 0; padding-top: 5px; font-weight: lighter; padding-bottom: 30px;"> Tasnim &amp; Atib </p>
                  </td>
                 </tr>';
  }

  if ($coming == 'Yes') {
    $message_guest .= '<tr>
                  <td bgcolor="#FFFFFF" style="padding: 20px 10px;" align="left">
                   
                    <p style="font-family: sans-serif; text-transform: capitalize; font-size: 14px; font-weight: lighter; letter-spacing: 1.5px;">Hello '.$first_name.'</p>

                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px;">Thank you for letting us know you will be able to to attend.</p>';
                    
                    if (isset($_POST['firstname_1']) ||
                            isset($_POST['lastname_1']) ||

                            isset($_POST['firstname_2']) ||
                            isset($_POST['lastname_2']) ||

                            isset($_POST['firstname_3']) ||
                            isset($_POST['lastname_3']) ||

                            isset($_POST['firstname_4']) ||
                            isset($_POST['lastname_4']) ||

                            isset($_POST['firstname_5']) ||
                            isset($_POST['lastname_5'])) {

                              if($firstname_1) {
                                $message_guest .= "<p style='text-transform: capitalize; font-family: sans-serif; margin: 0; font-size: 14px; letter-spacing: 0.5px;'> Guest 1: \n".clean_string($first_name)." ".clean_string($last_name)."</p>";
                                $message_guest .= "<p style='text-transform: capitalize; font-family: sans-serif; margin: 0; font-size: 14px; letter-spacing: 0.5px;'> Guest 2: \n".clean_string($firstname_1)." ".clean_string($lastname_1)."</p>";
                              }

                              if($firstname_2){
                                $message_guest .= "<p style='text-transform: capitalize; font-family: sans-serif; margin: 0; font-size: 14px; letter-spacing: 0.5px;'>Guest 3: \n".clean_string($firstname_2)." ".clean_string($lastname_2)."</p>";
                              }

                              if($firstname_3){
                                $message_guest .= "<p style='text-transform: capitalize; font-family: sans-serif; margin: 0; font-size: 14px; letter-spacing: 0.5px;'>Guest 4: \n".clean_string($firstname_3)." ".clean_string($lastname_3)."</p>";
                              }
                              if($firstname_4){
                                $message_guest .= "<p style='text-transform: capitalize; font-family: sans-serif; margin: 0; font-size: 14px; letter-spacing: 0.5px;'>Guest 5: \n".clean_string($firstname_4)." ".clean_string($lastname_4)."</p>";
                              }
                              if($firstname_5){
                                $message_guest .= "<p style='text-transform: capitalize; font-family: sans-serif; margin: 0; font-size: 14px; letter-spacing: 0.5px;'>Guest 6: \n".clean_string($firstname_5)." ".clean_string($lastname_5)."</p>";
                              }
                      }



    $message_guest .=  '<br />

                    <p style="border-bottom: 1px solid #EFEFEF; margin: 0; padding: 0;"></p>
                    <p style="font-family: sans-serif; text-transform: uppercase; font-size: 12px; letter-spacing: 1.5px; padding-top: 10px; font-weight: lighter;">
                       Details of location 
                    </p>

                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px;">Radisson Blu Edwardian New Providence Wharf
                    <br />5 Fairmont Ave<br /> Canary Wharf<br />London, E14 9JB</p>

                    <p style="border-bottom: 1px solid #EFEFEF; margin: 0; padding: 0;"></p>
                    <p style="font-family: sans-serif; text-transform: uppercase; font-size: 12px; letter-spacing: 1.5px; padding-top: 10px; font-weight: lighter;">
                       Details of ceremonies &amp; reception 
                    </p>
                    
                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px;">Date: 26th March 2017</p>

                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px;">Arrivals &amp; Welcome: 1:00 - 1:30pm <br />Nikkah Ceremony: 1:30 - 2:15pm <br />Lunch: 2:00pm <br />Exchaging Rings &amp; Cake Cutting: 4:00 - 4:30pm <br />Speeches + Tea &amp; Coffee: 4:30pm </p>
                      <p style="border-bottom: 1px solid #EFEFEF; margin: 0; padding: 0;"></p>
                    <p style="border-bottom: 1px solid #EFEFEF; margin: 0; padding: 0;"></p>
                    <br />
                    <p style="font-family: sans-serif; font-size: 12px; letter-spacing: 1px; font-style: italic; font-weight: lighter;" >
                      The minute I heard my first love story, I started looking for you, not knowing how blind that was. Lovers don\'t finally meet somewhere. They’re in each other all along. 
                      <span style="font-weight: normal;">- Rumi</span>
                    </p>

                    <br />
                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1px; margin: 0; padding-top: 10px; font-weight: lighter;"> With Love &amp; Respect
                    </p>
                    <p style="font-family: sans-serif; font-size: 14px; letter-spacing: 1.5px; margin: 0; padding-top: 5px; font-weight: lighter; padding-bottom: 30px;"> Tasnim &amp; Atib </p>


                  </td>
                 </tr>';
  }

  $message_guest .= '<tr>
                    <td bgcolor="#F3EEEE" height="120" align="center">
                      <span style=" color: transparent; border: 2px solid #CFAE88; padding: 11px 7px 10px; font-family: serif; letter-spacing: -1px;">
                        <p style=" display: inline-block; padding: 0; margin: 0; color: black; font-weight: 100; z-index: 1000;text-transform: uppercase; letter-spacing: -1px;" >
                          t&amp;a
                        </p>
                      </span>
                      <p style="font-family: sans-serif;
                        font-weight: lighter;
                        color: #1b1b1b;
                        padding-top: 20px;
                        text-transform: uppercase;
                        margin: 0;
                        font-size: 11px;
                        letter-spacing: 1.5px;"  >
                        Tasnim &amp; Atib
                      </p>
                    </td>
                  </tr>'; 

  $message_guest .= '  </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';


  // To send HTML mail, the Content-type header must be set
  $guest_headers = 'From: Tasnim & Atib <rsvp@tasnimandatib.co.uk>' . "\r\n" ;
  $guest_headers .='Reply-To: '. $email_to . "\r\n" ;
  $guest_headers .='X-Mailer: PHP/' . phpversion();
  $guest_headers .= "MIME-Version: 1.0\r\n";
  $guest_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";  

  // create email headers
   
  $headers = 'From: '.$email_from."\r\n";
  $headers .= 'Reply-To: '.$email_from."\r\n";
  $headers .= 'X-Mailer: PHP/' . phpversion();
   
  @mail($email_to, $email_subject, $email_message, $headers); 

  @mail($guest_email, $guest_subject, $message_guest, $guest_headers);

 
?>
 



		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
				<div class="row sectionBackground">
					<div class="col-xs-12">
						<div class="row">
              <div class="col-sm-12">
                <p class="p_logo_top">
                  <span class="logo">
                    <a href="/">
                     T&amp;A
                    </a>
                  </span>
                </p>
              </div>
            </div>


						<div class="row" >
							<div class="col-sm-12" >
								<h3>
									Thank You!
								</h3>
								<p> Thank you for sending us your RSVP. We will send a confirmation email very soon. </p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<p class="p_logo">
			<span class="logo">
        <a href="/">
         T&amp;A
        </a>
      </span>
		</p>
		<p class="credit">
      Copyright &copy; 2016<br>
			Designed &amp; Developed by <a href="https://atib.github.io">Atib</a>
		</p>
	</div>
	


	<script type="text/javascript" src="assets/js/dist/wedding.min.js"></script>
	<script type="text/javascript" src="app/app.js"></script>

</body>
</html>






 
 
 
<?php
 
}
 
?>


