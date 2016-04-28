<div class="page-header">
  <h1>Feedback</h1>
  <p class="text-right">Total feedback: <?php echo $total_rows; ?></p>
</div>
<div class="static-page">		
	      <div id="booking" class="table-responsive">
	        <table class="table table-bordered table-hover">		          
	            <thead>
	            <tr>
	              <th>Id</th>
	              <th>name</th>
	              <th>email</th>
	              <th>phone</th>
	              <th>score</th>
	              <th>message</th>
	              <th>Feedback date</th>	              
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($feedback_list as $key => $feedback) { ?>
	            <tr>
	              <td><?php echo $feedback->f_id;?></td>
	              <td><?php echo $feedback->name;?></td>
	              <td><?php echo $feedback->email;?></td>
	              <td><?php echo $feedback->phone;?></td>	              
	              <td><?php echo $feedback->score;?></td>
	              <td><?php echo $feedback->message;?></td>	                            
	              <td><?php echo date(DATE_FORMAT, strtotime($feedback->udate));?></td>
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