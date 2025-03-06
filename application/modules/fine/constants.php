<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/*
    |--------------------------------------------------------------------------
    | File and Directory Modes
    |--------------------------------------------------------------------------
    |
    | These prefs are used when checking and setting modes when working
    | with the file system.  The defaults are fine on servers with proper
    | security, but you may wish (or even need) to change the values in
    | certain environments (Apache running a separate process for each
    | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
    | always be used to set the mode correctly.
    |
   */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
    |--------------------------------------------------------------------------
    | File Stream Modes
    |--------------------------------------------------------------------------
    |
    | These modes are used when working with fopen()/popen()
    |
   */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

define('TABLE_PREFIX', 'cpnl_');
define('TABLE_PREFIX_RANA', 'rana_');
define('UPLOAD_PATH', './assets/uploads/');

define('DEFAULT_THUMB_H', 200);
define('DEFAULT_THUMB_W', 200);

define('FILE_UPLOAD_PATH', '../assets/uploads/');

//define('FOLLOW_UP_STATUS', serialize(array('4' => 'Hot+', '1' => 'Hot', '2' => 'Warm', '3' => 'Cold')));
//define('ENQUIRY_UP_STATUS', serialize(array('4' => 'Hot+', '1' => 'Hot', '2' => 'Warm', '3' => 'Cold')));

define('FOLLOW_UP_STATUS', serialize(array('1' => 'Hot+', '2' => 'Hot', '3' => 'Warm', '4' => 'Cold')));
define('ENQUIRY_UP_STATUS', serialize(array('1' => 'Hot+', '2' => 'Hot', '3' => 'Warm', '4' => 'Cold')));

define('VEHICLE_DETAILS_STATUS', serialize(array('1' => 'Sell', '2' => 'Buy', '3' => 'Exchange')));

//define('FUAL', serialize(array('2' => 'Diesel', '1' => 'Petrol', '3' => 'Gas', '4' => 'Hybrid', '5' => 'Electric', '6' => 'CNG')));
define('FUAL', serialize(array(
  '6' => 'CNG',
  '2' => 'Diesel',
  '5' => 'Electric',
  '3' => 'Gas',
  '4' => 'Hybrid',
  '1' => 'Petrol'
)));
define('CUST_AGE_GROUP', serialize(array('20-30' => '20-30', '30-40' => '30-40', '40-50' => '40-50', '50-60' => '50-60')));
/* define('MODE_OF_CONTACT', serialize(array(
    '1' => 'CUG-RD',
    '9' => 'Walk in',
    '7' => 'OLX-RD',
    '16' => 'Car Wale',
    '14' => 'Car Trade',
    '2' => 'Whatsup',
    '3' => 'Mail',
    '4' => 'Facebook',
    '5' => 'Events',
    '6' => 'Referal-RD',
    '8' => 'Fasttrack',
    '10' => 'C/O MD',
    '11' => 'C/O VP',
    '12' => 'C/O CEO',
    '13' => 'C/O Others',
    '15' => 'Just Dial',
    '17' => 'Field'))); */
define('MODE_OF_CONTACT', serialize(array(
  '1' => 'CUG-RD-IN',
  '27' => 'Courtesy call',
  //    '25' => 'CUG-RD-OUT',
  '9' => 'Walk in',
  '7' => 'OLX-RD',
  '16' => 'Car Wale',
  '14' => 'Car Trade',
  '2' => 'Whatsapp',
  '3' => 'Mail',
  '4' => 'Facebook-RD',
  '5' => 'Events',
  '6' => 'Referal-Own',
  '8' => 'Fasttrack',
  '10' => 'C/O MD',
  '11' => 'C/O VP',
  '12' => 'C/O CEO',
  '13' => 'C/O Others',
  '15' => 'Just Dial',
  '17' => 'Field',
  '18' => 'CUG-Own',
  '19' => 'OLX-Own',
  '20' => 'Facebook-Own',
  '21' => 'Telecall-RD',
  '22' => 'Google',
  '23' => 'Instagram-RD',
  '24' => 'India mart-RD',
  '26' => 'Web enquiry-RD-OUT',
  '28' => 'Happy call',
  '29' => 'DB List',
  '30' => 'Own-others',
  // '31' => 'Rd staff Referal',
  '32' => 'WHC',
  '33' => 'RD Customer referral (Delivery)',
  '34' => 'Referal',
  '35' => 'Google my business',
  '36' => 'Magazine',
  '37' => 'Youtube Channel',
  '38' => 'Foxium',
  '39' => 'Notice distribution',
  '40' => 'Visitor',
  '41' => 'Web-Refer & Win',
  '42' => 'OLX auto dealer',
  '43' => 'RD Customer referral (Purchase)',
  '44' => 'Lift-ADD',
  '45' => 'Growth father Whatsapp',
  '46' => 'Growth father Facebook',
  '47' => 'Growth father Google',
  '48' => 'Delivery retention',
  '49' => 'Lost retention',
  '50' => 'Madhyamam paper add',
  '51' => 'RD Care CUG IN'
)));
define('MODE_OF_CONTACT_FOLLOW_UP', serialize(array('1' => 'Telephone', '2' => 'Direct meet', '3' => 'Showroom visit')));
define('INSURANCE_TYPES', serialize(array('1' => 'RTI', '2' => 'Platinum/Gold/Silver', '3' => 'B2B', '4' => 'First Class', '5' => 'Second Class', '5' => 'Third party')));
//define('EVALUATION_TYPES', serialize(array('1' => 'Our own', '2' => 'Park and sale', '4' => 'Park and sale with dealer', '3' => 'Park and sale with customer')));
define('EVALUATION_TYPES', serialize(array('1' => 'Own', '4' => 'Park and sale with dealer', '3' => 'Park and sale with customer', '5' => 'Exchange', '6' => 'Buy back', '7' => 'Sales return')));

/* Definition for today */
define('TODAY', 'DATE(CURDATE())');
define('YESTERDAY', 'DATE(DATE_ADD(CURDATE(), INTERVAL -1 DAY))');

define('MAIN_SITE', 'http://royaldrive.in/');

define('ENQ_QUESTION_TYPES', serialize(array(
  1 => 'Common (Enquiry)', 2 => 'Sale (Enquiry)',
  3 => 'Buy (Enquiry)', 4 => 'Exchange (Enquiry)', 5 => 'Followup'
)));

define(
  'ENQ_VEHICLE_TYPES',
  serialize(
    array(
      1 => 'SUV', 2 => 'Sedan', 3 => 'Convertible', 4 => 'Coupe',
      5 => 'MUV-MPV', 6 => 'Sports', 7 => 'Hatchback',
      8 => 'Cruiser bike', 9 => 'Sport bike', 10 => 'Off road bike',
      11 => 'Super luxury cars', 12 => 'Compact SUV', 13 => 'Saloon'
    )
  )
);

define('YEAR_RANGE_START', 1989);

//Enquiry status
define('inquiry_reopened', 14);
define('assign_to_other_staff', 15);
define('loss_of_sale_or_buy', 4);
define('sale_closed', 6);
define('vehicle_booked', 13);
define('reject_book', 27);
define('confm_book', 28);
define('cancl_book', 29);
define('book_delvry', 40);
define('rfi_loan_approved', 42);
define('dc_ready_to_del', 43);

define('enq_lost', 5);
define('enq_req_drop', 2);
define('enq_droped', 3);
define('enq_verfd_close', 7);

//Website default thumb size (home page slider)
define('WB_DE_THUMB_H', 238);
define('WB_DE_THUMB_W', 380);

define('SMTP_HOST', 'mail.royaldrive.in');
define('SMTP_PORT', 25);
define('SMTP_USER', 'admin@royaldrive.in');
define('SMTP_PASS', 'rdadmin#@1');

define(
  'CALL_TYPE',
  serialize(
    array(
      1 => 'Qualified lead',
      2 => 'Non qualified lead',
      3 => 'Call not attend',
      4 => 'Wrong number',
      5 => 'Just enquiry',
      6 => 'NRI Call',
      7 => 'Net call',
      8 => 'Demo call',
      9 => 'Advertisement',
      10 => 'Duplicte call already assigned',
      11 => 'Waiting for reply',
      12 => 'Line busy',
      13 => 'Not reachable'
      //      12 => 'Courtesy call',
      //      13 => 'Happy call'
    )
  )
);

define(
  'VAL_DOCUMENT_TYPE',
  serialize(
    array(
      1 => 'RC',
      2 => 'Insurance',
      3 => 'Form 29',
      4 => 'Form 30',
      5 => 'Spec',
      6 => 'Tax token',
      7 => 'Pollution',
      8 => 'NOC',
      9 => 'Service history',
      10 => 'Purchase Customer Aadhaar',
      11 => 'Purchase Customer PAN',
      12 => 'Purchase agreement',
      13 => 'Sales agreement'
      //9 => 'Form 29'
    )
  )
);

//Register status
define('reg_new_register', 0);
define('reg_alrd_inq_punched', 1);
define('reg_req_drop', 16);
define('reg_droped', 17);

//Voxbay call status
define('VB_CONNECTED', 18);
define('VB_CANCEL', 19);
define('VB_BUSY', 20);
define('VB_CHANUNAVAIL', 21);
define('VB_CONGESTION', 22);
define('VB_NOANSWER', 23);
define('VB_NOT_CONNECTED', 24);
define('ADMIN_ID', 100);
define('GRP_SALES_OFFICER', 8);

define('add_stock', 39);
define('vehicle_evaluated', 12);

define('RFI_PAYMENT_MODE', serialize(
  array(
    1 => 'Bank',
    2 => 'Finance',
    3 => 'Cash',
    4 => 'Exchange',
    5 => 'Other + Other loan'
  )
));

define('PREFERENCE_KEYS', serialize(array(1 => 'Color', 2 => 'Registration', 3 => 'Other State', 4 => 'Vehicle type', 5 => 'RTO')));
define('PURCHASE_PERIOD', serialize(array(1 => 'Immediate', 2 => 'With in 1 Month', 3 => 'With in 3 Month')));
define('REFERAL_TYPES', serialize(array(1 => 'Broker', 2 => 'NVS', 3 => 'Dealer', 4 => 'RD Staff', 5 => 'RD Customer')));
define('GENDER', serialize(array('1' => 'Male', '2' => 'Female')));
define('LEAD_STATUS', serialize(array('1' => 'Negotiation', '2' => 'Booking', '3' => 'Finance Processing', 4 => 'Payment Processing', 5 => 'Delivery', 6 => 'Invoiced', 7 => 'Closed', 8 => 'Post Sales Follow up', 9 => 'Invalid Lead', 10 => 'Dropped Lead', 11 => 'Lost Lead', 12 => 'Cancelled Lead')));
define('INV_AMOUNT', serialize(array('1' => '50 Lac', '2' => '50 Lac - 1 Cr', '3' => '1 Cr above')));
define('INV_CONV_TIME', serialize(array(1 => '12 AM', 2 => '01 AM', 3 => '02 AM', 4 => '03 AM', 5 => '04 AM', 6 => '05 AM', 7 => '06 AM', 8 => '07 AM', 9 => '08 AM', 10 => '09 AM', 11 => '10 AM', 12 => '11 AM', 13 => '12 PM', 14 => '01 PM', 15 => '02 PM', 16 => '03 PM', 17 => '04 PM', 18 => '05 PM', 19 => '06 PM', 20 => '07 PM', 22 => '08 PM', 23 => '09 PM', 24 => '10 PM', 25 => '11 PM')));
define('Showrooms', serialize(array(1 => 'Malappuram', 2 => 'Calicut', 4 => 'Kochi')));
define('TRANSMISSIONS', serialize(array(1 => 'M/T', 2 => 'A/T', 3 => 'S/T', 4 => 'IMT', 5 => 'IVT', 6 => 'CVT', 7 => 'DCT', 8 => 'AMT')));

// define('PRODUCT_BASE_URL', 'https://royaldrive.s3.ap-south-1.amazonaws.com/products/');

define('DATE_FORMAT', 'd-M-Y H:i:s'); // 01-JAN-2023 24:00:00
define('DATE_FORMAT_QRY_D', "'%d-%b-%Y'"); // 01-JAN-2023
define('DATE_FORMAT_QRY_DT', "'%d-%b-%Y %H:%i:%s'"); // 01-JAN-2023 24:00:00
define('lostDrop', serialize(array(
  '1' => 'Lost to Competitor', '2' => 'Lost to New Car Dealer', '3' => 'Customer Shifted to Other Country', '4' => 'Took Used Car from Friend', '5' => 'Took Used Car from Friend', '6' => 'Took Used Car from Third Party', '7' => 'Customer Not at all Interested', '8' => 'Transferred to Smart Section', '9' => 'Pricing', '10' => 'Duplicate Entry', '12' => 'Others'
))); //jsk

define('MOU_VEH_IDENT_COMPONENTS', serialize(
  array(
    //    1 => 'Engine Number',
    //    2 => 'Chassis Number',
    3 => 'Gear box'
  )
)); //jk
define('PURCHASE_CHK_LIST_VALUE', serialize(array(
  0 => 'NO',
  1 => 'YES',
  2 => 'NA'
)));

define('RELIVING_REASON', serialize(array(
  1 => 'Looking for career growth',
  2 => 'Organizational restructuring',
  3 => 'Terminating',
  4 => 'Health issues',
  5 => 'Terrible boss',
  6 => 'Family shifting',
  7 => 'Family issues',
  8 => 'Personal issues',
  9 => 'Abroad job opportunities',
  10 => 'Terrible boss',
  11 => 'Terrible boss',
  12 => 'Department changes',
  13 => 'Higher studies',
  14 => 'Absconding',
  15 => 'Starting new business',
  16 => 'DND'
)));


//AWS
define('AWS_KEY', "AKIA45A5R7NCGHN2KU3O"); //Access key ID
define('AWS_SEC', "Am0vxD1qjcm+7ng0ed0pB/0Hrtvp4/PTPzsKMauh"); //Secret access key
define('AWS_REG', "ap-south-1"); //Region
define('AWS_VER', "latest"); //version
define('AWS_BUC', "royaldrive-prod"); //Bucket
// define('PRODUCT_BASE_URL', 'https://d391tzkxi3pmkh.cloudfront.net/');
define('PRODUCT_BASE_URL', 'https://royaldrive-prod.s3.ap-south-1.amazonaws.com/');

define('VAL_TYPE_TITLE', serialize(array(
  2 => 'Luxury Cars',
  1 => 'Budjected Cars',
  3 => 'Bikes'
)));

define('SOURCING_TYPE', serialize(array(
  1 => 'Outright Purchase',
  2 => 'Conditional Purchase',
  3 => 'Purchase for Park & Sale'
)));
define('SERVICE_STATION', serialize(array(
  '1' => 'RD Care Kochi',
  '3' => 'Makka centre (CLT)',
  '4' => 'Lap 47 (CLT)',
  '5' => 'Kakar (CLT)',
  '6' => 'Auto jockey (CLT)',
  '7' => 'Yes tyres (CLT)',
  '8' => 'Evm bmw (CLT)',
  '9' => 'Pps audi (CLT)',
  '10' => 'Benz Bridge way motors (CLT)',
  '11' => 'Volvo omega motors (CLT)',
  '12' => 'Bal tyres (CLT)',
  '13' => 'Hitech (MPM)',
  '14' => 'Carx (MPM)',
  '15' => 'Car Club (MPM)',
  '16' => 'Machingal auto (MPM)',
  '17' => 'Hindustan workshop (MPM)',
  '18' => 'Sai motors (MPM)',
  '19' => 'Amg automotive (MPM)',
  '20' => 'Automall (MPM)'
)));
