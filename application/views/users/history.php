<div class="page-header">
  <h1>History</h1>
</div>
<div class="static-page">		
	      <div id="booking" class="table-responsive">
	        <table class="table table-bordered table-hover">		          
	          <thead>
	            <tr>
	              <th>Order Id</th>
	              <th>Ride</th>
	              <th>Total</th>
	              <th>Paid</th>
	              <th>Balace</th>
	              <th>Pickup Date</th>
	              <th>Order Status</th>
	              <th>Book date</th>
	              <!-- th>Pay</th-->	              
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($book_list as $key => $book) {?>
	            <tr <?php echo ($book->due > 0)?'class="danger"':'';?>>
	              <td><?php echo $book->order_id;?></td>
	              <td><?php echo $book->ride_name;?></td>
	              <td><?php echo $book->total;?></td>
	              <td><?php echo money_format('%!i', $book->paid);?></td>
	              <td><?php echo money_format('%!i', $book->due);?></td>
	              <td><?php echo date(DATE_FORMAT, strtotime($book->pickup_datetime));?></td>
	              <td><?php echo $book->payment_status;?></td>
	              <td><?php echo date(DATE_FORMAT, strtotime($book->cdate));?></td>	              
	              <?php if($book->due > 0) {?>
	              	<!-- td><button type="button" class="btn btn-danger">Pay</button></td-->
	              <?php }?>	              
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