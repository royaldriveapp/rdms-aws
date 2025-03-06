<div class="x_content" style="overflow-x: auto;">
    <table id="myTable">
        <tbody>
            <tr class="header-row">
                <th rowspan="2" style="background-color: #b9ebc1;">Division</th>
                <th rowspan="2" style="background-color: #a9ecad;">Showroom</th>
                <th rowspan="2" style="background-color: #dbc1c1;">Present Rating</th>
                <th rowspan="2" style="background-color: #dbc1c1;">No. of Rewviews as of today	</th>
                <th rowspan="2" style="background-color: #dbc1c1;">Total RW's Received Till Yesterday</th>
                <th rowspan="2" style="color: white; background-color: #939b81;">Total RW's Received for the month of (<?php echo $previousMonthName ?>)</th>
                <th rowspan="2" style="background-color: #dbc1c1;">Total RW's with Photo</th>
                <th rowspan="2" style="background-color: #dbc1c1;">Leading team (Review Received for the month)</th>
            </tr>
            <tr class="sub-header"></tr>

            <?php foreach ($division_data as $division_item) : ?>
                <?php foreach ($division_item['shrm_data'] as $index => $shrm_data) : ?>
                    <tr>
                        <?php if ($index === 0) : ?>
                            <td rowspan="<?= count($division_item['shrm_data']) ?>"><?php echo htmlspecialchars($division_item['name']); ?></td>
                        <?php endif; ?>
                        <td><?php echo htmlspecialchars($shrm_data['name']); ?></td>
                        <td <?php echo ($date == date('d-m-Y')) ? 'contenteditable="true"' : ''; ?> onclick="showEdit(this);" onkeyup="saveRating(this, <?php echo $shrm_data['shrm_id']; ?>, '<?php echo $date; ?>');" onkeypress="return isDecimal(event);">
                            <?php echo $shrm_data['rating'] !== null ? htmlspecialchars($shrm_data['rating']) : '0'; ?>
                        </td>
                        <td <?php echo ($date == date('d-m-Y')) ? 'contenteditable="true"' : ''; ?> onclick="showEdit(this);" onkeyup="saveTodaysRwCount(this, <?php echo $shrm_data['shrm_id']; ?>, '<?php echo $date; ?>');" onkeypress="return isNumberKey(event);">
                        <?php echo $shrm_data['rwCount'] !== null ? htmlspecialchars($shrm_data['rwCount']) : '0'; ?>
                        </td>
                        <td>  <?php echo $shrm_data['yesterdaysRws'] !== null ? htmlspecialchars($shrm_data['yesterdaysRws']) : '0'; ?></td>
                        <td><?php echo $shrm_data['tot_motnth_wise_rws'] !== null ? htmlspecialchars($shrm_data['tot_motnth_wise_rws']) : '0'; ?></td>
                        <td <?php echo ($date == date('d-m-Y')) ? 'contenteditable="true"' : ''; ?> onclick="showEdit(this);" onkeyup="saveTodaysNoOfRwsWithPhoto(this, <?php echo $shrm_data['shrm_id']; ?>, '<?php echo $date; ?>');" onkeypress="return isNumberKey(event);">
                        <?php echo $shrm_data['rws_with_photo'] !== null ? htmlspecialchars($shrm_data['rws_with_photo']) : '0'; ?>
                        </td>
                        <td>0</td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function isDecimal(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    // Allow numeric characters (0-9) and one decimal point (.)
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
        return false;
    }

    // Get the value of the input field
    var inputValue = evt.target.value;

    // Check if the character is a decimal point and if the input already contains a decimal point
    if (charCode === 46 && inputValue.indexOf('.') !== -1) {
        return false;
    }

    return true;
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
