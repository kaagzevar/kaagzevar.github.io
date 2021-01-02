	<?php
	if(!isset($_POST['submit']))
	{
		//This page should not be accessed directly. Need to submit the form.
		echo "error; you need to submit the form!";
	}


	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$message = $_POST['message'];
	$location = $_POST['location'];

	//Validate first
	if(empty($name)||empty($visitor_email))
	{
		echo "Name and email are mandatory!";
		exit;
	}

	if(IsInjected($visitor_email))
	{
		echo "Bad email value!";
		exit;
	}

	//generate a new id
	$datetime_array = getdate();
	$year = $datetime_array{year};
	$mon = $datetime_array{mon};
	$mday = $datetime_array{mday};
	$hours = $datetime_array{hours};
	$minutes = $datetime_array{minutes};
	$seconds = $datetime_array{seconds};

	$regdate = $mday."-".$mon."-".$year;
	$regtime = $hours.":".$minutes;

	//echo "year = ". $year%2000;
	//echo "seconds without = ". $seconds;
	//echo "seconds = ". floor( $seconds/10 );

	// we want just the last digit
	$year = $year%2000;

	// Paid version of our programs should be different, lets subtract 2 from the year;
	//$year = $year - 2;

	// we want just the first digit
	$seconds = floor( $seconds/10 );

	if ($mon < 10) $mon = "0".$mon;
	if ($mday < 10) $mday = "0".$mday;
	if ($hours < 10) $hours = "0".$hours;
	if ($minutes < 10) $minutes = "0".$minutes;

	//echo "\n mon = ".$mon;
	//echo "\n mday = ".$mday;
	//echo "\n hours = ".$hours;
	//echo "\n minutes = ".$minutes;
	//echo "\n seconds = ".$seconds;


	$registrationno = "P".$year.$mon.$mday.$hours.$minutes.$seconds;



	$email_from = 'KaagZevar@gmail.com';//<== update the email address
	$email_subject = "Summer Workshop 2016 : $registrationno";
	$email_body = "You have received a new message from: \n\nName: $name \nEmail: $visitor_email \nMessage: $message \nLocation: $location \n\n".


	$to = $email_from;//<== update the email address
	$headers = "From: $email_from \r\n";
	$headers .= "Reply-To: $visitor_email \r\n";
	//Send the email!
	mail($to,$email_subject,$email_body,$headers);
	//done. redirect to thank-you page.
	header('Location: thanks.html');


	// Function to validate against any email injection attempts
	function IsInjected($str)
	{
	  $injections = array('(\n+)',
				  '(\r+)',
				  '(\t+)',
				  '(%0A+)',
				  '(%0D+)',
				  '(%08+)',
				  '(%09+)'
				  );
	  $inject = join('|', $injections);
	  $inject = "/$inject/i";
	  if(preg_match($inject,$str))
		{
		return true;
	  }
	  else
		{
		return false;
	  }
	}

?>