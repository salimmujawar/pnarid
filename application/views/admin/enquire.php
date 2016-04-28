<div class="page-header">
  <h1>Enquire</h1>
  <p class="text-right">Total enquire: <?php echo $total_rows; ?></p>
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
	              <th>enquiry</th>
	              <th>campaign</th>
	              <th>Enquire date</th>	              
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($enquire_list as $key => $enquire) { ?>
	            <tr>
	              <td><?php echo $enquire->e_id;?></td>
	              <td><?php echo $enquire->name;?></td>
	              <td><?php echo $enquire->email;?></td>
	              <td><?php echo $enquire->phone;?></td>	              
	              <td><?php echo $enquire->enquiry;?></td>
	              <td><?php echo $enquire->campaign;?></td>	                            
	              <td><?php echo date(DATE_FORMAT, strtotime($enquire->udate));?></td>
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