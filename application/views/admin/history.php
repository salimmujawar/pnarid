<div class="page-header">
  <h1>History</h1>
  <p class="text-right">Total bookings: <?php echo $total_rows; ?></p>
</div>
<div class="static-page">		
	      <div id="booking" class="table-responsive">
	        <table class="table table-bordered table-hover">		          
	            <thead>
	            <tr>
	              <th>Order Id</th>
	              <th>Ride</th>
	              <th>Coupon</th>
	              <th>Total</th>
	              <th>Paid</th>
	              <th>Balace</th>
	              <th>Pickup Date</th>
	              <th>Pickup</th>
	              <th>Drop</th>
	              <th>Customer</th>
	              <th>Contact</th>
	              <th>Vendor</th>
	              <th>Contact</th>
	              <th>PG Status</th>
	              <th>Book date</th>	              
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($book_list as $key => $book) { ?>
	            <tr>
	              <td><?php echo $book->order_id;?></td>
	              <td><?php echo $book->ride_name;?></td>
	              <td><?php echo $book->coupon;?></td>
	              <td><?php echo $book->total;?></td>
	              <td><?php echo money_format('%!i', $book->paid);?></td>
	              <td><?php echo money_format('%!i', $book->due);?></td>
	              <td><?php echo date(DATE_FORMAT, strtotime($book->pickup_datetime));?></td>
	              <td><?php echo $book->from_city;?></td>
	              <td><?php echo $book->to_city;?></td>	
	              <td><?php echo $book->cust_name;?></td>
	              <td><?php echo $book->cust_phone;?></td>	 
	              <td><?php echo $book->cust_name;?></td>
	              <td><?php echo $book->vend_phone;?></td>
	              <td><?php echo $book->payment_status;?></td>	               
	              <td><?php echo date(DATE_FORMAT, strtotime($book->cdate));?></td>
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