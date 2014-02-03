<?php 
class Send_Email extends Admin_Controller {
    public function Send_Email() 
    {
        parent::__construct();
                    
        $this->load->config('swiftmailer', TRUE);
        $email_config = $this->config->item('email_config', 'swiftmailer');

        $this->transporter = Swift_SmtpTransport::newInstance($email_config['smtp'], $email_config['port'], $email_config['secure'])
		  ->setUsername($email_config['username'])
		  ->setPassword($email_config['password']);        
    }

     public function sendemail($from, $arrayTo, $arrayCC, $arrayBCC, $subject, $msg)
     {
		$this->mailer = Swift_Mailer::newInstance($this->transporter);
		$logger = new Swift_Plugins_Loggers_ArrayLogger();
		$this->mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

		$message = Swift_Message::newInstance();
		$message->setSubject($subject)
				->setFrom($from)
				->setTo($arrayTo)
				->setCc($arrayCC)
				->setCc($arrayBCC)
				->setBody($msg);

		$status = !$this->mailer->send($message,$failures) ? $failures : 'Sent';
		ChromePhp::log($status);
		ChromePhp::log($logger->dump());
     }      
}