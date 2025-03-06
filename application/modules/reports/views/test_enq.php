<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Enquires jj...</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table style="width:100%">
                            <caption>Enquiry Details</caption>
                            <thead>
                                <tr>
                                    <th>SM</th>
                                    <th>ASM</th>
                                    <th>Sales Consultant</th>
                                    
                                    <th>Total Enquiry</th>
                                    <th>Hot</th>
                                    <th>Hot Plus</th>
                                    <th>Warm</th>
                                    <th>Cold</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$previous_sm_id = null;
$previous_asm_id = null;


// Initialize a counter for colors


$bg_color = '#f2f2f2';

foreach ($enquiry_data as $row): ?>
<?php if ($previous_sm_id !== $row->sm_id): ?>
        <?php  $bg_color = ($bg_color === '#f2f2f2') ? '#bed0efb8' : '#f2f2f2'; // Toggle background color ?>
    <?php endif; ?>
    <tr style="background-color: <?php echo $bg_color; ?>">
        <?php if ($previous_sm_id !== $row->sm_id): ?>
            <td id="<?php echo $row->sm_id; ?>" ><?php echo $row->SM; ?></td>
           
        <?php else: ?>
            <td>---</td>
        <?php endif; ?>
    
        <?php if ($previous_asm_id !== $row->asm_id): ?>
            <td id="<?php echo $row->asm_id; ?>"><?php echo $row->ASM; ?></td>
        <?php else: ?>
            <td>--</td>
        <?php endif; ?>

 
            <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->Sales_Consultant; ?></td>
     


        <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->total_enquiry; ?></td>
        <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->hot; ?></td>
        <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->hot_plus; ?></td>
        <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->warm; ?></td>
        <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->cold; ?></td>
    </tr>
    
    <?php
    $previous_sm_id = $row->sm_id;
    $previous_asm_id = $row->asm_id;
  //  $previous_sales_consultant_id = $row->Sales_Consultant_id;
    ?>
<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
