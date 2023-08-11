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
                $message_body = $this->do_purchase_email();
                break;

            case 'teaser':
                $message_body = $this->do_teaser_email();
                break;
            
            case 'coupon':
                $message_body = $this->do_coupon_email();
                break;

            default:
                $message_body = $this->do_coupon_email();
                break;
        }
        return $message_body;

    }


    private function do_purchase_email() {
        $html_string = <<<END
            <html><body style="background:#efefef;padding:40px 20px;">
			<div style="background:#ffffff;padding:3vw;width:92%; max-width:600px;margin:0 auto;">
            	<div><img style="width:auto;height:60px;" src="https://dagora-reports.hidora.com/wp-content/uploads/LOGO-DAGORA_NEW-300x91-1.png"><br></div>
            	<div>
                	<h2>Dear $this->recipient_fname </h2>
                    <p>Thank you for purchasing on the Dagorà Reports eShop. <strong>Your payment was preocessed correctly</strong>
					and shortly you will receive the tax documentation, always at the same email address provided.</p>
                    <div style="padding:20px;background:#efefef;">
                        <p><a href='$this->downloads_url' target='_blank'>Click here</a> to access your reports on our website.</p>
                    </div>
                <p>If you have any issues or queries, please reach out to us at: <a href="mailto:info@dagora.ch">info@dagora.ch</a></p>
                <p><em>The Dagorà team</em></p></br>
            </div>
            <div style="background:#0084cb;padding:40px 20px;color:white;">
                <img style="width:auto;height:40px;" src="https://dagora-reports.hidora.com/wp-content/uploads/LOGO-DAGORA_W-300x63-1.png"><br>
                <p style="color:white;">Dagorà brings together brands, tech companies, investors and start-ups for a stronger, more innovative LifestyleTech ecosystem.</p>
                <p style="color:white;"><strong><a style="color:white;" href="https://community.dagora.ch/join-us">Join Dagorà today</a></strong> to get free access to all reports, events and community programmes
                and to build your network in Switzerland and beyond.</p>
            </div>
			</div></body></html>
END;
    return $html_string;
    
    }


    private function do_coupon_email() {
        $html_string = <<<END
            <html><body style="background:#efefef;padding:40px 20px;">
			<div style="background:#ffffff;padding:3vw;width:92%; max-width:600px;margin:0 auto;">
            	<div><img style="width:auto;height:60px;" src="https://dagora-reports.hidora.com/wp-content/uploads/LOGO-DAGORA_NEW-300x91-1.png"><br></div>
            	<div>
                	<h2>Dear $this->recipient_fname </h2>
                    <p>Thank you for visiting the Dagorà Reports eShop. <strong>The reports you requested are now available</strong>.</p>
                    <div style="padding:20px;background:#efefef;">
                        <p><a href='$this->downloads_url' target='_blank'>Click here</a> to access your reports on our website.</p>
                    </div>
                <p>If you have any issues or queries, please reach out to us at: <a href="mailto:info@dagora.ch">info@dagora.ch</a></p>
                <p><em>The Dagorà team</em></p></br>
            </div>
            <div style="background:#0084cb;padding:40px 20px;color:white;">
                <img style="width:auto;height:40px;" src="https://dagora-reports.hidora.com/wp-content/uploads/LOGO-DAGORA_W-300x63-1.png"><br>
                <p style="color:white;">Dagorà brings together brands, tech companies, investors and start-ups for a stronger, more innovative LifestyleTech ecosystem.</p>
                <p style="color:white;"><strong><a style="color:white;" href="https://community.dagora.ch/join-us">Join Dagorà today</a></strong> to get free access to all reports, events and community programmes
                and to build your network in Switzerland and beyond.</p>
            </div>
			</div></body></html>
END;
    return $html_string;
    
    }



    private function do_teaser_email() {
        $html_string = <<<END
            <html><body style="background:#efefef;padding:40px 20px;">
			<div style="background:#ffffff;padding:3vw;width:92%; max-width:600px;margin:0 auto;">
            	<div><img style="width:auto;height:60px;" src="https://dagora-reports.hidora.com/wp-content/uploads/LOGO-DAGORA_NEW-300x91-1.png"><br></div>
            	<div>
                	<h2>Dear $this->recipient_fname </h2>
                    <p>Thank you for visiting the Dagorà Reports eShop. <strong>Your preview resources are now available</strong>.</p>
                    <div style="padding:20px;background:#efefef;">
                        <p><a href='$this->downloads_url' target='_blank'>Click here</a> to access your reports on our website.</p>
                    </div>
                <p>If you have any issues or queries, please reach out to us at: <a href="mailto:info@dagora.ch">info@dagora.ch</a></p>
                <p><em>The Dagorà team</em></p></br>
            </div>
            <div style="background:#0084cb;padding:40px 20px;color:white;">
                <img style="width:auto;height:40px;" src="https://dagora-reports.hidora.com/wp-content/uploads/LOGO-DAGORA_W-300x63-1.png"><br>
                <p style="color:white;">Dagorà brings together brands, tech companies, investors and start-ups for a stronger, more innovative LifestyleTech ecosystem.</p>
                <p style="color:white;"><strong><a style="color:white;" href="https://community.dagora.ch/join-us">Join Dagorà today</a></strong> to get free access to all reports, events and community programmes
                and to build your network in Switzerland and beyond.</p>
            </div>
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
        $sendSmtpEmail['subject'] = 'Download your Dagorà reoprts';
        $sendSmtpEmail['htmlContent'] = $this->email_body;
        $sendSmtpEmail['sender'] = array('name' => 'Dagorà', 'email' => 'info@dagora.ch');
        $sendSmtpEmail['to'] = array(
            array('email' => $this->recipient_email, 'name' => $this->recipient_fname . $this->recipient_lname)
        );
        $sendSmtpEmail['replyTo'] = array('email' => 'info@dagora.ch', 'name' => 'Dagorà');
        
        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $e) {
            echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }	
        
    }

}
   