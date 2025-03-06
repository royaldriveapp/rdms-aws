<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class smtp_test extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Test SMTP';
       }

       function index() {


            $this->load->library('email');
            $config['protocol'] = "smtp";
   
          $config['smtp_host'] = 'smtp.gmail.com';
          $config['smtp_port'] = '587'; // Change to TLS port
          $config['smtp_crypto'] = 'tls'; // Enable TLS encryption
          $config['smtp_user'] = 'talktoroyaldriveit@gmail.com';
          $config['smtp_pass'] = 'tfac kyur gxbh rpxt';
      
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";
          //  debug($config['smtp_user']);

            $this->email->initialize($config);

         $this->email->from('talktoroyaldriveit@gmail.com', 'Test');
         
           $list = array('cmjsadikh313@gmail.com');
            $this->email->to($list);
    
         $this->email->reply_to('talktoroyaldriveit@gmail.com', 'jRd test Mail');
            $this->email->subject('This is an email test');
            $this->email->message('It is working. Great!');

         if($this->email->send()) {
          echo 'Email sent successfully!';
          exit;
      } else {
          show_error($this->email->print_debugger());
      }
            $this->render_page(__CLASS__ . '/index');
       }
       




    public function send_bulk() {
     /*config/email.php*/
     // Load email library  
     $this->load->library('email');
     $this->email->from('megaplexcurtains@gmail.com', 'Royal Drive');
     
     // Add multiple recipients
     $recipients = array(
         'cmjsadikh313@gmail.com',
         'jsdeveloper17@gmail.com',
         'jkmorayur@gmail.com'
        
     );
     $this->email->to($recipients);
 
     $this->email->subject('Email Test');
     $this->email->message('Testing Bulk ......');
 
     // Send email
     if($this->email->send()) {
         echo 'Bulk Email sent successfully!';
     } else {
         show_error($this->email->print_debugger());
     }
 }
 
public function microsoft(){

     $this->load->library('email');
     $this->email->from('it@royaldrive.in', 'Rd365');
$this->email->to('cmjsadikh313@gmail.com');
$this->email->subject('Email Test');
$this->email->message('Testing Microsoft mail.. ');

if ($this->email->send()) {
    echo 'Email sent successfully!';
} else {
    show_error($this->email->print_debugger());
}

}


  }
  