<link href="../vendors/dropzone/dropzone.css" type="text/css" rel="stylesheet"/>
<script src="../vendors/dropzone/dropzone.js" type="text/javascript"></script>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update valuation</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-wrench"></i>
                                   </a>
                                   <ul class="dropdown-menu" role="menu"></ul>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <form class="x_content frmNewValuation">
                         <input type="hidden" name="val_id"/>
                         <div id="wizEvaluation">
                              <ul>
                                   <li><a href="#step-1">Step 1<br /><small>Evaluation lead creation</small></a></li>
                                   <li><a href="#step-2">Step 2<br /><small>Vehicle evaluation details</small></a></li>
                                   <li><a href="#step-3">Step 3<br /><small>Structural Hits and Damages</small></a></li>
                                   <li><a href="#step-4">Step 4<br /><small>Documents</small></a></li>
                                   <li><a href="#step-5">Step 5<br /><small>Vehicle images</small></a></li>
                              </ul>
                              <div>
                                   <div id="step-1" class="">
                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Evaluation lead creation</h3>
                                        </div>
                                   </div>

                                   <div id="step-2" class="">
                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Evaluation lead creation</h3>
                                        </div>
                                   </div>

                                   <div id="step-3" class="">
                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Evaluation lead creation</h3>
                                        </div>
                                   </div>

                                   <div id="step-4" class="">
                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Evaluation lead creation</h3>
                                        </div>
                                   </div>

                                   <div id="step-5" class="step-5">
                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Evaluation lead creation</h3>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </form>
               </div>
          </div>
     </div>
</div>

<style>
     .frame01 {background-image: url("images/01dim.jpeg");}
     .frame02 {background-image: url("images/02dim.jpeg");}
     .frame03 {background-image: url("images/03dim.jpeg");}

     .frame04 {background-image: url("images/04dim.jpeg");}
     .frame05 {background-image: url("images/05dim.jpeg");}
     .frame06 {background-image: url("images/06dim.jpeg");}

     .frame07 {background-image: url("images/07dim.jpeg");}
     .frame08 {background-image: url("images/08dim.jpeg");}
     .frame09 {background-image: url("images/09dim.jpeg");}

     .frame10 {background-image: url("images/10dim.jpeg");}
     .frame11 {background-image: url("images/11dim.jpeg");}
     .frame12 {background-image: url("images/12dim.jpeg");}

     .frame13 {background-image: url("images/13dim.jpeg");}

     .divFile {
          float: left;
     }
     .content{
          width: 300px;
          height: 300px;
          padding: 5px;
          float: left;
     }
     .content span{
          width: 250px;
     }
     .dz-message{
          text-align: center;
          font-size: 15px;
     }

     /* The container */
     .ctrl-container {
          display: block;
          position: relative;
          padding-left: 35px;
          /*margin-bottom: 12px;*/
          margin-bottom: 0px !important;
          cursor: pointer;
          font-size: 13px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
     }

     /* Hide the browser's default radio button */
     .ctrl-container input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
     }

     /* Create a custom radio button */
     .checkmark {
          position: absolute;
          top: 0;
          left: 0;
          height: 15px;
          width: 15px;
          background-color: #eee;
          border: 1px solid black;
          border-radius: 50%;
     }

     /* On mouse-over, add a grey background color */
     .ctrl-container:hover input ~ .checkmark {
          background-color: #ccc;
     }

     /* When the radio button is checked, add a blue background */
     .ctrl-container input:checked ~ .checkmark {
          background-color: #2196F3;
          border: 1px solid #2196F3;
     }

     /* Create the indicator (the dot/circle - hidden when not checked) */
     .checkmark:after {
          content: "";
          position: absolute;
          display: none;
     }

     /* Show the indicator (dot/circle) when checked */
     .ctrl-container input:checked ~ .checkmark:after {
          display: block;
     }

     /* Style the indicator (dot/circle) */
     .ctrl-container .checkmark:after {
          top: 19%;
          left: 20%;
          width: 7px;
          height: 8px;
          border-radius: 50%;
          background: white;
     }
     .td-head {
          background-color: #ebcccc;color: black;
     }

     /*Features*/
     .chk-container {
          max-width: 100%;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          font-size: 13px;
     }

     ul.ks-cboxtags {
          list-style: none;
          padding: 20px;
     }
     ul.ks-cboxtags li{
          display: inline;
     }
     ul.ks-cboxtags li label{
          display: inline-block;
          background-color: rgba(255, 255, 255, .9);
          border: 2px solid rgba(139, 139, 139, .3);
          color: #adadad;
          border-radius: 25px;
          white-space: nowrap;
          margin: 3px 0px;
          -webkit-touch-callout: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          -webkit-tap-highlight-color: transparent;
          transition: all .2s;
     }

     ul.ks-cboxtags li label {
          padding: 8px 12px;
          cursor: pointer;
     }

     ul.ks-cboxtags li label::before {
          display: inline-block;
          font-style: normal;
          font-variant: normal;
          text-rendering: auto;
          -webkit-font-smoothing: antialiased;
          font-family: "FontAwesome";
          font-weight: 900;
          font-size: 12px;
          padding: 2px 6px 2px 2px;
          content: "\f067";
          transition: transform .3s ease-in-out;
     }

     ul.ks-cboxtags li input[type="checkbox"]:checked + label::before {
          content: "\f00c";
          transform: rotate(-360deg);
          transition: transform .3s ease-in-out;
     }

     ul.ks-cboxtags li input[type="checkbox"]:checked + label {
          border: 2px solid #1bdbf8;
          background-color: #12bbd4;
          color: #fff;
          transition: all .2s;
     }

     ul.ks-cboxtags li input[type="checkbox"] {
          display: absolute;
     }
     ul.ks-cboxtags li input[type="checkbox"] {
          position: absolute;
          opacity: 0;
     }
     ul.ks-cboxtags li input[type="checkbox"]:focus + label {
          border: 2px solid #e9a1ff;
     }
     .form-control {margin-bottom: 5px;}
     /**/
</style>

<!-- Include SmartWizard CSS -->
<link href="../vendors/jwizard/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<!-- Optional SmartWizard theme -->
<link href="../vendors/jwizard/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
<link href="../vendors/jwizard/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
<link href="../vendors/jwizard/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />


7902215540
9745003023