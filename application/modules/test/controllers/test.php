<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Admin_Controller {

    protected $mailer,$transporter;

	function __construct(){
        parent::__construct();
        $this->load->config('swiftmailer', TRUE);
        $email_config = $this->config->item('email_config', 'swiftmailer');

        $this->transporter = Swift_SmtpTransport::newInstance($email_config['smtp'], $email_config['port'], $email_config['secure'])
		  ->setUsername($email_config['username'])
		  ->setPassword($email_config['password']);
    }

	public function index(){
		ChromePhp::log('hello world');
	}

	public function helloworld(){
		$this->mailer = Swift_Mailer::newInstance($this->transporter);
		$logger = new Swift_Plugins_Loggers_ArrayLogger();
		$this->mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
		$this->config->load('swiftmailer');
        $swift_config = $this->config->item('email_config', 'swiftmailer');
        $from = array("{$swift_config['from']}" => 'No Reply Kompas Gramedia');
		$message = Swift_Message::newInstance();
		$message->setSubject('My Subject')
				->setFrom($from)
				->setTo(array(
					'trisna@unpad.ac.id' => 'Trisna'
					))
				// ->setCc(array(
				//   'ishakq@gmail.com' => 'Pak Ishaq'
				// ))
				// ->setBcc(array(
				//   'ishakq@gmail.com' => 'Pak Ishaq'
				// ))
				->setBody('Hello World Apa Kabar Dunia dari swift mailer SMTP UNPAD Kompas');

		$status = !$this->mailer->send($message,$failures) ? $failures : 'Sent';
		// ChromePhp::log('hello world');
		ChromePhp::log($status);
		ChromePhp::log($logger->dump());
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
