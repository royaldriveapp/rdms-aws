<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ORDER FORM</h2>
                    &nbsp; <button type="submit" class="btn btn-info no-print" id="print_btn"><i class="fa fa-print"
                            style="color:white"></i> Print</button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div style="text-align: center;"> <img src="images/print_logo2.jpg" style="width: 200px;" />
                        <h5><b><u>ORDER FORM</u></b></h5>
                    </div>

                    <table class="table table-bordered table1">
                        <tbody>
                            <!--                                        <tr>
                                        <th colspan="2" style="text-align: center;">Customer details</th>
                                   </tr>-->
                            <tr class="tr1">
                                <td class="td1">Customer name : <?php echo $bookingDetails['vbk_cust_name']; ?></td>
                                <td class="td2">Date :
                                    <?php echo date('d-m-Y', strtotime($bookingDetails['vbk_added_on'])); ?>
                                    <span style="float: right;"><?php echo $bookingDetails['vbk_ref_no'] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Permanent address : <?php echo $bookingDetails['vbk_per_address']; ?></td>
                                <td>RC Transfer address : <?php echo $bookingDetails['vbk_rd_trans_address']; ?></td>
                            </tr>
                            <tr>
                                <td>Phone number (Official) : <?php echo $bookingDetails['vbk_off_ph_no']; ?></td>
                                <td>Pan Card : <?php echo @$panCard['vbd_doc_number']; ?>


                                </td>

                            </tr>
                            <tr>
                                <td>Phone number (Personal) : <?php echo $bookingDetails['vbk_per_ph_no']; ?></td>
                                <td>Email ID : <?php echo $bookingDetails['vbk_email']; ?></td>
                            </tr>
                            <tr>
                                <td>Date of Birth :
                                    <?php echo (!empty($bookingDetails['vbk_dob'])) ? date('d-m-Y', strtotime($bookingDetails['vbk_dob'])) : ''; ?>
                                </td>
                                <td>Address proof :
                                    <?php if (!empty($bookingDetails['addressProof'])) { ?>
                                    <table class="table table-bordered tblBokDocs">

                                        <?php
                                                       foreach ((array) $bookingDetails['addressProof'] as $key => $value) {
                                                            if (!empty($value['adp_proof_title'])) {
                                                       ?>
                                        <tr class="trBokDocs">
                                            <td>
                                                <?php echo $value['adp_proof_title']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['vbd_doc_number']; ?>
                                            </td>
                                            <!--                                                       <td>
                                                                        <?php if (!empty($value['vbd_doc_file'])) { ?>
                                                                                                      <a target="_blank" href="<?php echo '../../assets/uploads/documents/booking/' . $value['vbd_doc_file']; ?>">
                                                                                                           <i title="View document" class="fa fa-eye"></i>
                                                                                                      </a>
                                                                        <?php } ?>
                                                                        </td>-->
                                        </tr>
                                        <?php
                                                            }
                                                       }
                                                       ?>
                                    </table>
                                    <?php } ?>


                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <div style="text-align: center;">
                        <h5><b>VEHICLE DETAILS</b></h5>
                    </div>
                    <table class="table table-bordered ">
                        <tbody>

                            <tr>
                                <td>
                                    Reg No: <?php echo strtoupper($bookingDetails['val_veh_no']); ?>
                                </td>
                                <td class="n-brd1">
                                    Model:
                                    <?php echo $bookingDetails['brd_title'] . ', ' . $bookingDetails['mod_title'] . ', ' . $bookingDetails['var_variant_name']; ?>

                                </td>
                                <td class="n-brd">
                                    <div style="float: left;"> Production Year :
                                        <?php echo $bookingDetails['val_minif_year']; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Chassis Number : <?php echo $bookingDetails['val_chasis_no']; ?>
                                </td>
                                <td class="n-brd1">
                                    <div style="width: 45%;float: left;">
                                        KM : <?php echo $bookingDetails['val_km']; ?>

                                    </div>

                                </td>
                                <td class="n-brd">
                                    <div style="float: left;">No of ownership :
                                        <?php echo $bookingDetails['val_no_of_owner']; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Insurance Company: <?php echo $bookingDetails['val_insurance_company']; ?>
                                </td>
                                <td class="n-brd1">
                                    Valid up to:
                                    <?php echo !empty($bookingDetails['val_insurance_comp_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_comp_date'])) : ''; ?>


                                </td>
                                <td class="n-brd">
                                    <div style="float: left;">IDV :
                                        <?php echo get_in_currency_format($bookingDetails['val_insurance_comp_idv']); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"> Warranty: As per the policies of manufacturer, Royal Drive has not
                                    liability on the same.</td>
                            </tr>


                        </tbody>
                    </table>
                    <!--- --->
                    <?php if (!empty($bookingDetails['refurb'])) { ?>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6 tb1">
                            <table class="table table-bordered tb1">
                                <tr>
                                    <th colspan="2" class="fl-wd">Price Details</th>
                                </tr>
                                <tr>
                                    <td>Vehicle sold price</td>
                                    <td style="width: 122px;"> <?php //echo get_in_currency_format($bookingDetails['vbk_vehicle_amt']);
                                                                                ?></td>

                                </tr>
                                <tr>
                                    <td>TCS</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_tcs']);
                                                       ?></td>

                                </tr>
                                <tr>
                                    <td>RTO transfer & Service charge</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_rto_charges']);
                                                       ?></td>

                                </tr>
                                <tr>
                                    <td>Refurbishment charge</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_refurbish_cost']);
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>Accessories charges</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_accessories_cost']); 
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>Total sales amount</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_ttl_sale_amt']); 
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>Advance Amount</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_advance_amt']); 
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>Balance Amount</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_balance']); 
                                                       ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 tb2">
                            <table class="table table-bordered tb2">
                                <tr>
                                    <th>Other Booking Conditions/Refurbishment jobs</th>
                                </tr>
                                <?php
                                             if (!empty($bookingDetails['refurb'])) {
                                                  foreach ((array) $bookingDetails['refurb'] as $key => $value) {
                                             ?>
                                <tr>
                                    <td>
                                        <?php echo $key + 1 . '. ' . $value['vbr_refurb_desc']; ?>
                                    </td>
                                </tr>
                                <?php
                                                  }
                                             }
                                             ?>
                            </table>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 ">
                            <table class="table table-bordered ">
                                <!-- <table class="table table-bordered " style="table-layout: fixed;"> -->
                                <tr>
                                    <th colspan="2" class="fl-wdk">Price Details</th>
                                    <th class="fl-wdk">Other Booking Conditions/Refurbishment jobs</th>
                                </tr>
                                <tr>
                                    <td Style="width:241px;">Vehicle sold price</td>
                                    <td style="width: 122px;"> <?php //echo get_in_currency_format($bookingDetails['vbk_vehicle_amt']); 
                                                                                ?></td>

                                    <td style="width: 400px;" rowspan="2"> 1</td>
                                </tr>
                                <tr>
                                    <td>TCS</td>
                                    <td><?php //echo ($bookingDetails['vbk_tcs'] > 0) ? get_in_currency_format($bookingDetails['vbk_tcs']) : ''; 
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>RTO transfer & Service charge</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_rto_charges']); 
                                                       ?></td>
                                    <td rowspan="2">2 </td>
                                </tr>
                                <tr>
                                    <td>Refurbishment charge</td>
                                    <td><?php //echo ($bookingDetails['vbk_refurbish_cost'] > 0) ? get_in_currency_format($bookingDetails['vbk_refurbish_cost']) : '';
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>Accessories charges</td>
                                    <td><?php //echo ($bookingDetails['vbk_accessories_cost'] > 0) ? get_in_currency_format($bookingDetails['vbk_accessories_cost']) : ''; 
                                                       ?></td>
                                    <td rowspan="2"> 3</td>
                                </tr>
                                <tr>
                                    <td>Total sales amount</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_ttl_sale_amt']);
                                                       ?></td>
                                </tr>
                                <tr>
                                    <td>Advance Amount</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_advance_amt']);
                                                       ?></td>
                                    <td rowspan="2"> 4</td>
                                </tr>
                                <tr>
                                    <td>Balance Amount</td>
                                    <td><?php //echo get_in_currency_format($bookingDetails['vbk_balance']);
                                                       ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
                    <!---@--->
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tr>
                                    <td width="25%">
                                        If By Finance :Bank name: <?php echo $bookingDetails['bnk_name']; ?>
                                    </td>
                                    <td width="25%">
                                        Load Amount :
                                        <?php echo $bookingDetails['vbk_loan_amt'] != 0 ? get_in_currency_format($bookingDetails['vbk_loan_amt']) : ''; ?>
                                    </td>
                                    <td width="25%">
                                        Tenor :
                                        <?php echo $bookingDetails['vbk_tenor'] != 0 ? $bookingDetails['vbk_tenor'] : ''; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 small">
                            <i>The approval of finance is purely the discretion of the finance company. Royal Drive has
                                no guarantee on the same.</i></br>
                            <p><u><b>I Undertake that :</b></u></p>
                            1) I have agreed to buy the above used vehicle and booked on above mentioned condition.</br>
                            2) I have checked the vehicle to my satisfaction and I am aware of all its defects and
                            buying 'as is where is'.</br>
                            3) I Understand that, Royal Drive is only liable to perform the additional conditions /
                            refurbishment mentioned in the Booking form. Other condition on the vehicle will be 'as is
                            where is'.</br>
                            4) I agree to pay an advance amount, 10%of the vehicle value; if the advance is lesser than
                            that value the same will be paid with in 48Hrs from booking date.</br>
                            5) I undertake to pay the balance amount on the price of the car with immediate effect and
                            am fully aware that the cancellation by the Customer will be made within 3 days from the day
                            of booking, no cancellation charge will be applicable. Cancellation made by customer after
                            that, Interest will be charged @10% of the sales value of the vehicle from the date of
                            booking.</br>
                            6) I understand that I cannot return the vehicle if any defects arise afterthe handover of
                            vehicle or for any other reason regarding this vehicle.</br>
                            7) I agree that I will pay the balance full amount in 3 days if buying on cash terms and 7
                            days if buying on finance.</br>
                            8) If I am failing to pay the amount with in specified period, Royal Drive is free to sell
                            the vehicle to other customer and I will take back refund of my booking as per booking
                            terms.</br>
                            9) Delivery of the vehicle only after the completion of the full payment.</br>
                            10) All the documents required for the finance has to submitted within 3 days to the finance
                            department, otherwise Royal Drive have authority to cancel the booking and sell the vehicles
                            to another customer.</br>
                            11) I have read the warranty terms and conditions of manufacturer and understand the same
                            completely</br>
                            12) I undertake that I will not hold Royal Drive for any consequences arising out of this
                            purchase and any defects in the vehicle, other than those covered under the warranty
                            conditions specified by the manufacturer.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="sgn">
                                <tr>
                                    <th width="50%"> Sales Officer</th>
                                    <th width="50%"> </th>
                                </tr>
                                <tr>
                                    <td width="50%"> Signature </td>
                                    <td width="50%"> </td>
                                </tr>
                                <tr>
                                    <td width="50%"> Date </td>
                                    <td width="50%"> </td>
                                </tr>
                                <tr>
                                    <td width="50%"> Team Leader </td>
                                    <td width="50%"> </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="sgn">
                                <tr>
                                    <th width="50%"> </th>
                                    <th width="50%">Customer Sign </th>
                                </tr>
                                <tr>
                                    <td width="50%"></td>
                                    <td width="50%">Name </td>
                                </tr>
                                <tr>
                                    <td width="50%"> </td>
                                    <td width="50%">Date </td>
                                </tr>
                                <tr>
                                    <td width="50%"> </td>
                                    <td width="50%"> Sales Manager / Branch Head </td>
                                </tr>
                            </table>


                        </div>
                    </div>

                    <div class="row mrgn">
                        <div class="col-md-12 ">

                            <b> Terms & Conditions </b></br>
                            a. Vehicle Details mentioned in Booking Form are accurate to the best of Seller's knowledge
                            as on date.</br>
                            b. Buyer Details mentioned in Booking form are accurate to Buyer's knowledge as on
                            date.</br>
                            c. The vehicle is sold on as- is- where is basis. I understand that I cannot return the
                            vehicle if any defects arise after purchase or for any other reason and have no claims on
                            the seller regarding the vehicle.</br>
                            d. Buyer shall ensure to transfer full payment (as mentioned in Order Form) 3 days if buying
                            on cash terms and 7 days if buying on instalment terms , whichever is earlier. </br>
                            e. Seller retains full right to cancel the booking; if the Buyer fail to transfer Total
                            Amount payable within the terms of booking form or-before delivery of vehicle to the Buyer,
                            without any prior notification.</br>
                            f. For payment is made in parts, in case balance amount is not paid by due date the
                            transaction shall be treated as cancelled by Buyer and the booking amount will be treated as
                            per the booking agreement.</br>
                            g. In case payment is made through cheque, delivery will be made once payment is reflected
                            in the accounts of Seller.
                            h. In vehicle finance cases, complete down payment or 25% of the sales price which ever is
                            higher should be received within 3 days of booking, else the booking will be treated as
                            cancelled by buyer and booking amount will be forfeited under booking norms.</br>
                            i. Seller shall get the vehicle registration transferred, if the deal includes the same.
                            Buyer shall pay additional charges, if any as notified by seller which shall be intimated to
                            Buyer at the time of booking.</br>
                            j. Buyer shall provide appropriate paper work and documentation for successful transfer of
                            vehicle registration. Seller shall not be liable to complete the registration transfer
                            process if the registration authorities deem the paperwork insufficient.</br>
                            k. Delivery date shall be communicated by Seller to Buyer. A minimum of 2 working days from
                            the date of booking shall be granted to Seller for getting the vehicle delivery ready.
                            Should however there be an unforeseen delay in getting the vehicle delivery ready due to any
                            additional work or refurbishment job mentioned in the booking form, the Seller shall
                            communicate the same to Buyer.</br>
                            I. Seller shall be granted a period of a maximum of 120 days for transfer of registration
                            subject to above points</br>
                            m. l am responsible to pay the Insurance transfer charges (Including NCB Charges ).</br>
                            n. Insurance transfer shall not be Seller's responsibility. The buyer has to get this
                            transferred via the Insurance agent or service provider </br>
                            o. After subsequent registration transfer, seller shall not be responsible or liable to get
                            any insurance claims successfully passed; neither shall the seller be responsible to provide
                            relevant paperwork the same.</br>
                            p. If customer is looking for a finance, he can contact finance team with all the documents
                            required for finance also customer have to follow with finance team terms and
                            condition.</br>
                            q. If any balance amount is to be paid irrespective of reason within stipulated time after
                            delivery, Vehicle has to be given back to Royal drive and the customer is liable to pay the
                            loss incurred during the course of time which will be decided by Royal drive itself.</br>
                            r. Customer is responsible to pay 1% of sales amount as TCS.</br>
                            s. This Booking Contract is subject to exclusive jurisdiction of courts at Malappuram.</br>
                            t. Buyer has read and understood the above terms and conditions and agrees to undersign the
                            same.


                        </div>
                    </div>
                    <div style="float: right;">Buyer's Signature </div>

                    <div class="row margn2">
                        <div class="col-md-12">

                            <h4><b>Park & Sell Vehicle special undertaking </b></h4>
                            a, I have purchased the above used vehicle belonging to Mr through Royal Drive.
                            </br>
                            b, I have checked the vehicle to my satisfaction and I am aware of all its defects. </br>
                            c, I am purchasing this vehicle in 'as is where is' condition and Royal drive is an onlya
                            service provider to facilitatethe sales.
                            </br>
                            d, In any case the seller may arise any issue on the subject on the vehicle to clear the
                            sales proceeding with Royal Drive, I understand that, Royal Drive will refund the full
                            booking amount and i don't have any further claim on the subject.
                            </br>
                            e, I understand that I cannot return the vehicle if any defects arise after purchase or for
                            any other reason and have no claim on Royal Drive regarding this vehicle.
                            </br>
                        </div>
                    </div>
                    <div style="float: right;">Buyer's Signature </div>








                </div>
            </div>
        </div>
    </div>
</div>
<style>
.table {
    width: 100%;
    max-width: 100%;
    margin-top: 5px;
    margin-bottom: 5px;
}

.mrgn {
    margin-top: 65px;
}

tablej {
    border-color: grey !important;
}

th,
td {
    padding-top: 2px !important;
    padding-bottom: 2px !important;
    /*  padding-left: 20px!important;
            padding-right: 30px!important;*/
}

.h4,
.h5,
.h6,
h4,
h5,
h6 {
    margin-top: 5px;
    margin-bottom: 3px;
}

.table,
.n-brd1 {

    border-right: none !important;
}

.table,
.n-brd {
    border-left: none !important;

}

.sgn {
    width: 100%;
    margin-top: 23px;
}

.margn2 {
    margin-top: 63px !important;
}

/*.table1,.td1{
           
             border-top: 1px solid #095484!important;
               border-bottom: 1px solid #095484!important;
                 border-left: 1px solid #095484!important;
                  border-right: 1px solid #095484!important;
          
     }
     .table1,.td2{
           
             border-top: 1px solid #cb3636!important;
               border-bottom: 1px solid #cb3636!important;
                 border-left: 1px solid #cb3636!important;
                  border-right: 1px solid #cb3636!important;
          
     }*/
.page {
    min-height: 29.7cm;
    background: white;
}

@media print {
    .pagebreak {
        float: none !important;
        position: static !important;
        display: inline;
        box-sizing: content-box !important;
        page-break-after: always;
    }
}

@media print {

    .alert,
    .ui-theme-settings,
    .no-print,
    .no-print * {
        display: none !important;
    }


    /*          html,
          body {
                avoid extra blank page while printing  
               height: 100vh;
               margin: 0 !important;
               padding: 0 !important;
               overflow: hidden;
          }*/
    .sgn {
        width: 100% !important;
    }
}

.tb1 {
    padding-right: 0px !important;
}

.tb2 {
    padding-left: 0px !important;
}

.x_panel {
    width: 100%;
    padding: 10px 17px;
    display: inline-block;
    background: #fff;
    border: none !important;
    -webkit-column-break-inside: avoid;
    -moz-column-break-inside: avoid;
    column-break-inside: avoid;
    opacity: 1;
    transition: all .2s ease;
}

.fl-wd {
    width: 115%;
}
</style>
<script>
$(document).ready(function() {
    $("#print_btn").click(function() {
        window.print();
    });
});
</script>