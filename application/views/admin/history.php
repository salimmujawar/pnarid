<div class="page-header">
  <h1>History</h1>
  <p class="text-right">Total bookings: <?php echo $total_rows; ?></p>
</div>
<div class="static-page">		
	      <div id="booking" class="table-responsive">
	        <table class="table table-bordered table-hover">		          
	            <thead>
	            <tr>
                      <th>Book Id</th>
	              <!--th>Order Id</th-->
	              <th>Ride</th>
                      <th>Journey</th>
                      <th>Trip</th>
	              <th>Coupon</th>
	              <th>Total</th>
	              <th>Paid</th>
	              <th>Balance</th>
	              <th>Pickup Date</th>
	              <th>Pickup</th>
	              <th>Drop</th>
	              <th>Customer</th>
	              <th>Contact</th>
	              <th>Vendor</th>
	              <th>Contact</th>
                      <th>Status</th>
	              <th>PG Status</th>
	              <th>Book date</th>	              
                      <th>Notify</th>
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($book_list as $key => $book) { ?>
	            <tr>
                      <td><a href="<?php echo base_url('admin/booking/vendors?b_id=' . $book->b_id); ?>"><?php echo $book->b_id;?></a></td>
	              <!--td><?php //echo $book->order_id;?></td-->
	              <td><?php echo $book->ride_name;?></td>
                      <td><?php echo $book->rent_type;?></td>
                      <td><?php echo $book->trip_type;?></td>
	              <td><?php echo $book->coupon;?></td>
	              <td><?php echo $book->total;?></td>
	              <td><?php echo money_format('%!i', $book->paid);?></td>
	              <td><?php echo money_format('%!i', $book->due);?></td>
	              <td><?php echo date(DATE_FORMAT, strtotime($book->pickup_datetime));?></td>
	              <td><?php echo $book->pickup . ', ' . $book->from_city;?></td>
	              <td><?php echo $book->to_city;?></td>	
	              <td><?php echo $book->cust_name;?></td>
	              <td><?php echo $book->cust_phone;?></td>	 
	              <td><?php echo $book->vend_name;?></td>
	              <td><?php echo $book->vend_phone;?></td>
                      <td><?php echo ($book->status)?'Successful':'Cancelled';?></td>
	              <td><?php echo $book->payment_status;?></td>	               
	              <td><?php echo date(DATE_FORMAT, strtotime($book->cdate));?></td>
                      <td><?php echo ($book->sms_notified)?'SMS Sent':'<a href="'.base_url('admin/booking/notify?b_id=' . $book->b_id).'">Notify</a>';?></td>
	            </tr>
	            <?php }?>	            
	          </tbody>	         
	        </table>
	      </div><!--end of .table-responsive-->
	       <div class="row">
	        <div class="col-md-12 text-center">
	            <?php echo $pagination; ?>
	        </div>
	    </div>
</div>