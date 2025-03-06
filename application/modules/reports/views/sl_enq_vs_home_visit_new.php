

<div id="ajx">

</div>


<script>
    $(document).ready(function() {// alert(313);
          $("#ajx").html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> </center>');
          init_chart_doughnut();      
    $.ajax({
        type: 'get',
        "url": site_url + "reports/sl_enq_vs_home_visit_ajx",
        success: function (resp) {
            $("#ajx").html(resp);
        }
    });
});


</script> 
