<!-- about Section -->
<section class="inner_pages" style="margin-top:133px;">
     <div class="container">
          <div class="row" style="padding:0px 0px 20px 0px">
               <div class="col-sm-12">
                    <!--<h1>Let us keep in touch</h1>-->
                    <div class="contact_box" style="margin-bottom: 0px;">
                         <div class="col-sm-8 padding_0">
                              <img src="images/promo.jpeg" />
                         </div>
                         <div class="col-sm-4 padding_0">
                              <div class="form_section">
                                   <div class="col-sm-12">
                                        <h2>Get in touch with us</h2>
                                   </div>
                                   <form action="" id="frmContactus" method="post" enctype="multipart/form-data">
                                        <input name="eve_event" type="hidden" value="18" />
                                        <input name="eve_type" type="hidden" value="1" />
                                        <div class="col-sm-12">
                                             <div class="form-group">
                                                  <input required autocomplete="off" type="text" name="eve_name" class="form-control" placeholder="Your name*">
                                             </div>
                                             <div class="form-group">
                                                  <input required minlength="10" autocomplete="off" type="text" name="eve_mobile" class="form-control numOnlyWithoutMsg" placeholder="Your phone number*">
                                             </div>
                                             <div class="form-group">
                                                  <input autocomplete="off" type="text" name="eve_location" class="form-control" placeholder="Your location">
                                             </div>
                                             <div class="form-group">
                                                  <input required autocomplete="off" type="email" name="eve_email" class="form-control" placeholder="Your email*" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                                             </div>
                                             <div class="form-group">
                                                  <!-- <select name="eve_vehicle" class="form-control">
                                                       <option value="0">Interested vehicle</option>
                                                       <option value="1157">Mercedes Benz CLA Class 45 AMG</option>
                                                       <option value="1672">Land Rover Range Rover LWB 3.0 Vogue</option>
                                                       <option value="2274">Lamborghini Urus MY 19</option>
                                                       <option value="2184">Toyota Land Cruiser 2 00 VX</option>
                                                       <option value="1515">Bentley Flying Spur W12</option>
                                                       <option value="1404">Mini Cooper Clubman S</option>
                                                  </select> -->
                                                  <input type="hidden" name="eve_vehicle" value="0" />
                                             </div>
                                        </div>
                                        <div class="col-sm-12">
                                             <div class="form-group">
                                                  <button type="submit" class="btn btn-primary btnSubmit">Send</button>
                                                  <div class="msgContactus"></div>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</section>

<script type="text/javascript" id="zsiqchat">
     var $zoho = $zoho || {};
     $zoho.salesiq = $zoho.salesiq || {
          widgetcode: "fe63d506c671ba46667b8018cab74406119acfb3006f534f8129d9cf9f3eedec084640d749c5a27dc8dc9bbec022e4d0",
          values: {},
          ready: function() {}
     };
     var d = document;
     s = d.createElement("script");
     s.type = "text/javascript";
     s.id = "zsiqscript";
     s.defer = true;
     s.src = "https://salesiq.zoho.in/widget";
     t = d.getElementsByTagName("script")[0];
     t.parentNode.insertBefore(s, t);
</script>