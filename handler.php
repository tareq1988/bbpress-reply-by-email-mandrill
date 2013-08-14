<?php
if ( !class_exists( 'bbSubscriptions_Handler' ) ) {
    $file = dirname( __DIR__ ) . '/bbPress-Reply-by-Email/library/bbSubscriptions/Handler.php';

    if ( file_exists( $file ) ) {
        require_once $file;
    } else {
        return;
    }
}

/**
 * Mandrill Subscription Handler
 * 
 * @author Tareq Hasan <tareq@wedevs.com>
 */
class bbSubscriptions_Handler_Mandrill implements bbSubscriptions_Handler {

    protected static $current_options = array();

    public function __construct( $options ) {}
    
    public function check_inbox() {}
    
    public static function options_section_header() {}

    public static function register_option_fields( $group, $section, $options ) {}

    public static function validate_options( $input ) {}

    public function send_mail( $users, $subject, $content, $attrs ) {
        extract( $attrs );

        foreach ($users as $user) {

            $from_address = sprintf( '%s <%s>', $reply_author_name, bbSubscriptions::get_from_address() );
            $reply_to = bbSubscriptions::get_reply_address( $topic_id, $user );
            $headers = "Reply-to:$reply_to\nFrom:$from_address";

            wp_mail( $user->user_email, $subject, $content, $headers );
        }
    }

    /**
     * Hanldes Mandrill inbound web hook
     * 
     * @return void
     */
    public function handle_post() {
        if ( isset( $_POST['mandrill_events'] ) ) {
            $parsed = reset( json_decode( stripslashes( $_POST['mandrill_events'] ) ) );

            if ( !$parsed ) {
                return;
            }

            $reply = new bbSubscriptions_Reply();
            $reply->from = $parsed->msg->from_email;
            $reply->subject = $parsed->msg->subject;
            $reply->body = $parsed->msg->text;

            list($reply->topic, $reply->nonce) = bbSubscriptions_Reply::parse_to( $parsed->msg->email );

            $reply_id = $reply->insert();
            
            if ( $reply_id === false ) {
                header( 'X-Fail: No reply ID', true, 400 );
                echo 'Reply could not be added?'; // intentionally not translated
                // Log this?
            }
        }
    }

    public static function get_name() {
        return 'Mandrill';
    }

}