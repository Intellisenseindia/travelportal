<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>

<div id="wrapper">

    <div class="content">

        <div class="row">

            <div class="col-md-12">
			
				<?php echo $trip->tripcode.' - '.$trip->trip_name; ?>
				<div class="project-menu-panel tw-my-5">
				 <?php $this->load->view('admin/trips/trip_tabs'); ?>
				 </div>

				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($customers as $costomer){ ?>
						<tr>
							<td><?php echo $costomer['company']; ?></td>
							<td><?php echo $costomer['phonenumber']; ?></td>
							<td><?php echo $costomer['email']; ?></td>
							<td><a class="btn btn-primary mright5 test pull-left display-block" onclick="addCustomer(<?php echo $trip->id; ?>,<?php echo $costomer['userid']; ?>);"><i class="fa-regular fa-plus tw-mr-1"></i></a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
function addCustomer(tripid,customerid){
	$.ajax({
        type: "POST",
        url: "<?php echo admin_url('trips/viewtrip/customerAdd'); ?>",
        //data: 'tripid='+ tripid + '&customerid='+ customerid',
		data: {tripid:tripid, customerid:customerid}
        success: function(data) {
            return data;
        }
    });
}

</script>

</body>
</html>