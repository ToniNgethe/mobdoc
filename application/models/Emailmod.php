<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Emailmod extends CI_Model {

    function template($message) {
        $message1 = '<div style="background:#f9f9f9;padding:20px"><span class="im"><div class="adM">
 </div><div style="max-width:460px;margin:0 auto"><div class="adM">
 </div><p style="font-size:16px;vertical-align:top;color:#3c4650;font-weight:500;text-align:center;border-radius:3px 3px 0 0;background-color:#f2f2f2;margin:0;padding:20px" bgcolor="#f2f2f2" valign="top" align="center">
							MobDoc medical <span class="il">appointments</span>
						</p>
						
 <div style="background:#fff;border:1px solid #e8e8e8;border-radius:3px;font-size:14px;padding:20px">
 You have <strong>1 <span class="il">appointment</span></strong> notification.
 <br><br>
 <p style="font-size:14px;vertical-align:top;margin:0;padding:0 0 20px" valign="top">
										'.$message.'
									</p>
									
									
									<div style="padding-top:20px">
 <a href="'.  base_url("signin").'" style="font-size:14px;color:#fff;text-decoration:none;line-height:2em;font-weight:bold;text-align:center;display:inline-block;border-radius:3px;text-transform:capitalize;background-color:#1aae88;margin:0;border-color:#1aae88;border-style:solid;border-width:10px 20px" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en&amp;q=http://mobdoc.crescentke.com/signin&amp;source=gmail&amp;ust=1495183002610000&amp;usg=AFQjCNEobxlJbLK4YG4gn8QgbHr7IxOuWQ">Login to your Account</a>
 </div>
 
 <p style="font-size:14px;vertical-align:top;margin:0;padding:20px 0 20px" valign="top">
										 Thanks for choosing MobDoc.
									</p>
 </div>
 </div>
 
 </span><div class="yj6qo"></div><div class="adL">
 
 </div></div>';
        return $message1;
    }

    function send_mail($userId, $userMessage) {

        $userDetails = $this->crudmod->get_record('user', 'userId', $userId);
        $message = $this->template($userMessage);

        $this->email->from('no-reply@mobdoc.com', 'MobDoc Appointments');
        $this->email->to($userDetails['email']);
        $this->email->subject('New appointment notification');
        $this->email->message($message);

        $s = $this->email->send();

        if ($s) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
