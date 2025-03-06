<thead>
     <tr>
          <th>Product Number</th>
          <th>Product Name</th>
          <th>Company</th>
          <!--<th>Purchase Rate</th>-->
          <!--<th>Qty</th>-->
          <th>Serial No</th>
          <th>Purchase date</th>
          <th>Warranty till</th>
          <th>Invoice</th>
          <th>Warranty Card</th>
          <th>Vendor</th>
          <th>Desc</th>
          <th><i class="glyphicon glyphicon-trash"></i></th>
          <th><i class="glyphicon glyphicon-plus btnAddNewRow"></th>
     </tr>
</thead>
<tbody class="tbdyProduct">
     <tr class="divRows">
          <td><input style="width:123px;" data-strlabel="proNumber" required type="text" name="product[prd_number][]" id="prd_number" class="form-control col-md-7 col-xs-12"/></td>
          <td><input style="width:123px;" data-strlabel="proName" required type="text" name="product[prd_name][]" class="form-control col-md-7 col-xs-12 "/></td>
          <td>
               <select name="product[prd_company][]" class="form-control col-md-7 col-xs-12">
                    <option value="">Select company</option>
                    <?php foreach ($company as $key => $value) { ?>
                         <option value="<?php echo $value['facm_id']; ?>"><?php echo $value['facm_title']; ?></option>
                    <?php } ?>
               </select>
          </td>
          <!--<td><input style="width:123px;" data-strlabel="proPrate" required type="text" name="product[purchase_rate][]" class="decimalOnly form-control col-md-7 col-xs-12 prdPrice"/></td>-->
          <!--<td><input style="width:123px;" data-strlabel="proQty" required type="text" name="product[prd_qty][]" class="decimalOnly form-control col-md-7 col-xs-12"/></td>-->
          <td><input style="width:123px;" data-strlabel="proQty" type="text" name="product[prd_slno][]" class="form-control col-md-7 col-xs-12"/></td>
          
          <td><input style="width:123px;" data-strlabel="proQty" type="text" name="product[prd_pur_on][]" class="dtpDMY form-control col-md-7 col-xs-12"/></td>
          
          <td><input style="width:123px;" data-strlabel="proQty" type="text" name="product[prd_warty_till][]" class="dtpDMY form-control col-md-7 col-xs-12"/></td>
          <td><input type="file" name="prd_invoice[]"/></td>
          <td><input type="file" name="prd_warty_card[]"/></td>

          <td><input style="width:123px;" data-strlabel="proQty" type="text" name="product[prd_vendor][]" class="form-control col-md-7 col-xs-12"/></td>
          <td><input style="width:123px;" data-strlabel="proQty" type="text" name="product[prd_desc][]" class="form-control col-md-7 col-xs-12"/></td>

          <td colspan="2"><a class="pencile btnDeleteNewRow" href="javascript:void(0);"><i class="glyphicon glyphicon-trash"></i></a></td>
     </tr>
</thead>