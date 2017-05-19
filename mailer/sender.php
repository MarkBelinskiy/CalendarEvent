<?php

class sender
{
	public $smtp_data = array(					
		"host"			=> 'smtp.yandex.ru',		//SMTP server
    	"debug"			=> 0,						
    	"debugoutput"	=> 'html',					
    	"auth"			=> true,					
    	"port"			=> 465,						
    	"username"		=> 'belinskiy-mark@ya.ru', //YOUR yandex EMAIL or add other smtp server to use some else email client
    	"password"		=> 'eleban03', 				//YOUR PASS
    	"fromname"		=> 'Administration', 		
    	"replyto"		=> array(
    		"address"	=> 'admin@admin.com', 	
    		"name"		=> 'Administrator'	
    		),
    	"notification"	=> array(
    		"address"	=> '',	
    		"name"		=> ''	
    		),
    	"secure"		=> 'ssl', 					
    	"charset"		=> 'UTF-8',					
    	"verify"		=> '0'						
    	);

		
	public $mail_content = array( 
		'title'		=> 'Invite',
		'header'	=> 'Hello! Click on the link bellow to register in our calendar).<br />',
		'footer'	=> ''
		);



	/**
	 *		The function "glues" the message with a static header and footer
	 *		
	**/
	private function fullText($to)
	{
		if(!empty($to))
		{

			return $this->mail_content['header'] .'<a href="'. $_SERVER['HTTP_HOST'].'/auth/register.php?email='. $to .'">Click me!</a>'. $this->mail_content['footer'];
		}
		else
		{
			die("Отсутствует текст письма");
		}
	}


	/**
	 * Function of sending a message to the mail 
	* Used if mail sending is enabled
	* If the sending was successful - returns 0, otherwise - the error log
	* Accepted data:
	* $ Smtp_data - data array for connection to SMTP
	* $ Message_data - data array of the content of the message itself and the addressee
	**/
	function addToDB($message_data)
	{
		require_once '../db/db_connect.php';

		$check_reg = $db->prepare("INSERT INTO `Authors`(`name`, `email`, `password`, `user_group`) VALUES ('', ?, '', '1')");
		$email = $message_data['to'];

		$check_reg->bindParam(1, $email);
		$check_reg->execute();
		$db = null;

		
	}
	function sendMail($smtp_data, $message_data)
	{
		require_once('PHPMailer/PHPMailerAutoload.php'); 
		$mail = new PHPMailer;
		$mail->isSMTP();
		if($smtp_data['verify'] == 0)
		{
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					));
		}

		$mail->Host       	= $smtp_data['host'];
		$mail->SMTPDebug  	= $smtp_data['debug'];
		$mail->Debugoutput	= $smtp_data['debugoutput'];
		$mail->SMTPAuth   	= $smtp_data['auth'];
		$mail->Port       	= $smtp_data['port'];
		$mail->Username   	= $smtp_data['username'];
		$mail->Password   	= $smtp_data['password'];
		$mail->SMTPSecure	= $smtp_data['secure'];
		$mail->CharSet 		= $smtp_data['charset'];

		$mail->setFrom($smtp_data['username'], $smtp_data['fromname']);
		$mail->addReplyTo($smtp_data['replyto']['address'], $smtp_data['replyto']['name']);
		if(!empty($smtp_data['notification']['address']))
		{
			$mail->addAddress($smtp_data['notification']['address'], $smtp_data['notification']['name']);
		}
		$mail->addAddress($message_data['to']);
		$mail->Subject = $message_data['title'];
		$mail->msgHTML($this->fullText($message_data['to']));

		if (!$mail->send()) 
		{
			die("Mailer Error: " . $mail->ErrorInfo);
		} 
		else 
		{
			return 0;
		}
	}
	
}

?>
