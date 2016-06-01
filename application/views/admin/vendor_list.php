<div class="page-header">
  <h1>Vendors</h1>
  <form action="<?php echo base_url('admin/booking/vendors');?>" class="form-inline">
    <div class="form-group">
      <label for="exampleInputName2">Address</label>
      <input type="text" class="form-control" id="venAddress" name="venAddress" value="<?php echo $address; ?>" placeholder="Address"/>
    </div>    
      <input type="hidden" name="b_id" value="<?php echo $book_id; ?>"/>
    <button type="submit" class="btn btn-default">Search</button>
    <a href="<?php echo base_url('admin/booking/vendors?b_id=' . $book_id);?>" class="btn btn-default">Reset</a>
</form>
  <p class="text-right">Total Vendors: <?php echo $total_rows; ?></p>
</div>
<div class="static-page">		
	      <div id="booking" class="table-responsive">                
                <form action="<?php echo base_url('admin/booking/index');?>" method="post">    
                    <input type="hidden" name="b_id" value="<?php echo $book_id; ?>"/>
	        <table class="table table-bordered table-hover">		          
	            <thead>
	            <tr>
                      <th>Select</th>
                      <th>Id</th>	              
	              <th>Email</th>
                      <th>first_name</th>
                      <th>phone</th>	              	              
                      <th>Address</th>
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($vendor_list as $key => $vendor) { ?>
	            <tr>
                      <td><input type="radio" name="vendor" class="" value="<?php echo $vendor->user_id;?>"/></td>	              
                      <td><?php echo $vendor->user_id;?></td>
	              <td><?php echo $vendor->email;?></td>
                      <td><?php echo $vendor->first_name;?></td>
                      <td><?php echo $vendor->phone;?></td>	              
                      <td><?php echo $vendor->address . ', ' . $vendor->city_name;?></td>	              
	            </tr>
	            <?php }?>	            
	          </tbody>                
	        </table>
                    <input type="submit" name="update_vendor" class="btn btn-danger btn-lg" value="Update"/>
                </form>
	      </div><!--end of .table-responsive-->
	       <div class="row">
	        <div class="col-md-12 text-center">
	            <?php echo $pagination; ?>
	        </div>
	    </div>
</div>