<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Smsmod extends CI_Model {

    function sendSMS($phoneNumber, $textMessage) {


        // Be sure to include the file you've just downloaded
        require_once(APPPATH . 'libraries/AfricasTalkingGateway.php');

        // Specify your login credentials
        $username = "bluewave";
        $apikey = "cb02cc32fad5518495c45ee111ea2c5d59f4ba6c57aacf4b2afb25ee197b0321";

        // Specify the numbers that you want to send to in a comma-separated list
        // Please ensure you include the country code (+254 for Kenya in this case)
        $recipients = $phoneNumber;

        // And of course we want our recipients to know what we really do
        $message = $textMessage;

        // Create a new instance of our awesome gateway class
        $gateway = new AfricasTalkingGateway($username, $apikey);

        // Any gateway errors will be captured by our custom Exception class below, 
        // so wrap the call in a try-catch block
        try {
            // Thats it, hit send and we'll take care of the rest. 
            $results = $gateway->sendMessage($recipients, $message);

            foreach ($results as $result) {
                return true;
            }
        } catch (AfricasTalkingGatewayException $e) {
            return false;
        }
    }

}
