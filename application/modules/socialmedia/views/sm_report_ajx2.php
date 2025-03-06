<?php
$divisions = $this->socialmedia->divisions();
$social_medias_common = $this->socialmedia->sm_common();

// Initialize variables for totals
$total_current_followers = 0;
$total_last_month_followers = 0;
$total_current_followers_common = 0;
$total_last_month_followers_common = 0;

// Arrays to store data for each division
$division_data = array();

// Fetch data for each division
foreach ($divisions as $division) {
    $social_medias = $this->socialmedia->sm($division->div_id);

    // Array to store data for each social media in the division
    $division_social_media_data = array();

    foreach ($social_medias as $social_media) {
        // Fetch followers count for today and last month

        $new_date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        
        
        $current_followers = $this->socialmedia->get_followers_count($social_media->sm_id, $new_date);
       // print_r( $current_followers);
        $last_month_followers = $this->socialmedia->get_followers_count($social_media->sm_id, $last_month_date);
        
        // Calculate growth percentage
        $growth = $this->socialmedia->calculate_growth($current_followers, $last_month_followers);

        // Update totals
        $total_current_followers += $current_followers;
        $total_last_month_followers += $last_month_followers;

        // Store data for the social media
        $division_social_media_data[] = array(
            'master_id'=>$social_media->sm_id,
            'name' => $social_media->sm_name,
            'current_followers' => $current_followers,
            'last_month_followers' => $last_month_followers,
            'growth' => $growth
        );
    }

    // Store data for the division
    $division_data[] = array(
        'name' => $division->div_name,
        'social_media_data' => $division_social_media_data
    );
}

// Fetch data for common social media
$common_social_media_data = array();
foreach ($social_medias_common as $social_media_common) {
    $current_followers_common = $this->socialmedia->get_followers_count($social_media_common->sm_id, $new_date);
  
    $last_month_followers_common = $this->socialmedia->get_followers_count($social_media_common->sm_id, $last_month_date);
    $growth_common = $this->socialmedia->calculate_growth($current_followers_common, $last_month_followers_common);

    $total_current_followers_common += $current_followers_common;
    $total_last_month_followers_common += $last_month_followers_common;

    $common_social_media_data[] = array(
        'master_id'=>$social_media_common->sm_id,
        'name' => $social_media_common->sm_name,
        'current_followers' => $current_followers_common,
        'last_month_followers' => $last_month_followers_common,
        'growth' => $growth_common
    );
}
?>

<div class="x_content" style="overflow-x: auto;">
    <!-- Table -->
    
    <table id="myTable">
        <tbody>
            <tr class="header-row">
                <th rowspan="2" style="background-color: #b9ebc1;">Division</th>
                <th rowspan="2" style="background-color: #a9ecad;">Social Media</th>
                <th rowspan="2" style="background-color: #dbc1c1;">No. of followers as of today</th>
                <th rowspan="2" style="color: white;background-color: #939b81;">No. of followers as of last month end (<?php echo $previousMonthName ?>)</th>
                <th rowspan="2" style="background-color: #1c5763;color: white;">Growth %</th>
            </tr>
            <tr class="sub-header"></tr>

            <?php foreach ($division_data as $division_item) : ?>
                <?php foreach ($division_item['social_media_data'] as $social_media_data) : ?>
                    <tr>
                        <?php if ($social_media_data === reset($division_item['social_media_data'])) : ?>
                            <td rowspan="<?= count($division_item['social_media_data']) ?>"><?php echo $division_item['name']; ?></td>
                        <?php endif; ?>
                        <td><?php echo $social_media_data['name']; ?></td>    
                        <td <?php echo ($date == date('d-m-Y')) ? 'contenteditable="true"' : ''; ?>  onClick="showEdit(this);" onkeyup="saveToDatabase(this,<?php echo $social_media_data['master_id']?>, '<?php echo $date ?>')" onkeypress="return isNumberKey(event);"><?php //echo $date ?> <?php echo $social_media_data['current_followers']; ?></td>
                        <td><?php echo $social_media_data['last_month_followers']; ?></td>
                        <td><?php echo $social_media_data['growth']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <?php foreach ($common_social_media_data as $common_social_media_item) : ?>
                <tr class="total-row">
                    <td colspan="2" style="background-color: #cfd95c8c;"><?php echo $common_social_media_item['name']; ?></td>
                    <td style="background-color: #E2E0ED;" <?php echo ($date == date('d-m-Y')) ? 'contenteditable="true"' : ''; ?>  onClick="showEdit(this);" onkeyup="saveToDatabase(this,<?php echo $common_social_media_item['master_id']?>,'<?php echo $date ?>')" onkeypress="return isNumberKey(event);"><?php echo $common_social_media_item['current_followers']; ?></td>
                    <td style="background-color: #E2E0ED;"><?php echo $common_social_media_item['last_month_followers']; ?></td>
                    <td style="background-color: #E2E0ED;"><?php echo $common_social_media_item['growth']; ?></td>
                </tr>
            <?php endforeach; ?>

           
        </tbody>
    </table>
    <!-- End table -->
</div>
