<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class MailerTool {

    // Takes parameters of: receipient email, recipient firstname/surname and message type.

    private $recipient_email;
    private $recipient_fname;
    private $recipient_lname;
    private $message_type;
    private $email_body;
    public $downloads_url;


    function __construct($mail, $fname, $lname, $type, $downloads_url) {

        $this->recipient_email = $mail;
        $this->recipient_fname = $fname;
        $this->recipient_lname = $lname;
        $this->message_type = $type;
        $this->downloads_url = $downloads_url;

        $this->email_body = $this->construct_email_body();
        $this->send_email();

    }


    private function construct_email_body() {

        switch ($this->message_type) {
            case 'report':
                $message_body = $this->do_welcome_email();
                break;

            case 'teaser':
                $message_body = $this->do_welcome_email();
                break;
            
            case 'coupon':
                $message_body = $this->do_welcome_email();
                break;

            default:
                $message_body = $this->do_welcome_email();
                break;
        }
        return $message_body;

    }


    private function do_welcome_email() {
        $html_string = <<<END
            <html><body style="background:#efefef;padding:40px 20px;">
			<div style="background:#ffffff;padding:3vw;width:92%; max-width:600px;margin:0 auto;">
            	<div><img style="width:100%;height:auto;" src="https://eluxurysummit.ch/wp-content/uploads/LINKEDIN_EVENT2.webp"><br></div>
            	<div>
                	<h2>Dear $this->recipient_fname </h2>
                    <p>Your link to download the reports is here: $this->downloads_url</p>
                <p>If you have any questions, feel free to contact us: <a href="mailto:operations@dagora.ch">operations@dagora.ch</a></p>
                <p><em>The Dagorà team</em></p>
            </div>
			<img style="width:100%;height:auto;" src="https://eluxurysummit.ch/wp-content/uploads/speakers-eluxury2023.jpg">
			</div></body></html>
END;
    return $html_string;
    
    }



    private function send_email() {	

        require_once(ABSPATH . 'wp-content/themes/dagora-reports-shop/vendor/autoload.php');
        $global_opts = get_option('wporg_options');
        $sib_key = $global_opts['brevo_api_key']; // Says Brevo, but is actually still SendInBlue

        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $sib_key);
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            $config
        );
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
        $sendSmtpEmail['subject'] = 'Welcome to our event';
        $sendSmtpEmail['htmlContent'] = $this->email_body;
        $sendSmtpEmail['sender'] = array('name' => 'Dagorà', 'email' => 'events@dagora.ch');
        $sendSmtpEmail['to'] = array(
            array('email' => $this->recipient_email, 'name' => $this->recipient_fname . $this->recipient_lname)
        );
        $sendSmtpEmail['replyTo'] = array('email' => 'events@dagora.ch', 'name' => 'Dagorà');
        
        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $e) {
            echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }	
        
    }

}
   