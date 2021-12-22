<?php
		$data = json_decode(file_get_contents('php://input'), true);
        $name=""; $email=""; $message=""; $captcha=""; $to=""; $from=""; $subject=""; $body="";

        if(isset($data['name'])){
          $name=$data['name'];
        }

		if(isset($data['email'])){
          $email=$data['email'];
        }

		if(isset($data['message'])){
          $message=$data['message'];
        }

		if(isset($data['g-recaptcha-response'])){
          $captcha=$data['g-recaptcha-response'];
	  }

		if($captcha !== '' && !$captcha){
          http_response_code(400);
          exit;
        }

        $from = 'Contact Form';
		//$to = 'vadim@chicagoveg.com';
        $to = 'greenish_green@yahoo.com';
		$subject = 'Message from Contact Form';
		$body = "From: $name\n E-Mail: $email\n Message:\n $message";

		session_start();

        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Leh-rodAAAAAJjD-18AyqD3ttf1KIhgCJ1OrfN-&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if($response == false)
        {
           http_response_code(400);
        }else if (mail ($to, $subject, $body, $from))
        {
        	http_response_code(200);
        }else {
          http_response_code(400);
        }

        session_destroy();
?>
