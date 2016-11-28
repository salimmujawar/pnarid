<div class="page-header">
  <h1>Analytics</h1>
  <p class="text-right">Total Search: <?php echo $total_rows; ?></p>
</div>
<form action="">
    <table>
        <tbody>
            <tr>
                <td>Cdate: </td><td><input id="datepick" type="text" name="cdate" value="<?php echo (!empty($_GET['cdate']))?$_GET['cdate']:'';?>"/>
                <td>&nbsp;Campainge: </td><td><input type="text" name="campainge" value="<?php echo (!empty($_GET['campainge']))?$_GET['campainge']:'';?>"/>
                <td>&nbsp;&nbsp;<a href="/admin/analytic/index" class="btn btn-danger">Refresh</a></td>
                <td>&nbsp;<input type="submit" class="btn btn-primary" name="submit" value="Query"/>
            </tr>
        </tbody>
    </table>
</form>
<div class="static-page">		
	      <div id="analyticing" class="table-responsive">
	        <table class="table table-bordered table-hover">		          
	            <thead>
	            <tr>
                      <th>Id</th>	              
	              <th>from</th>
                      <th>to</th>
                      <th>Start Dt</th>
                      <th>Return Dt</th>
                      <th>campainge</th>
                      <th>keyword</th>
                      <th>match</th>
                      <th>device</th>
                      <th>ip</th>
                      <th>distance</th>
                      <th>price</th>
                      <th>cdate</th>	              	             
	            </tr>
	          </thead>
	          <tbody>
	          	<?php foreach($analytic_list as $key => $analytic) { 
                            $post = json_decode($analytic->post, true);
                            //$query = parse_url($analytic->referer, PHP_URL_QUERY);
                            //parse_str($query, $query_arr);
                            //print_r($query_arr);        
                        ?>
	            <tr>
                      <td><?php echo $analytic->id;?></td>
	              <!--td><?php //echo $analytic->order_id;?></td-->
	              <td><?php echo (isset($post['journeySaddr']))?$post['journeySaddr']:'';?></td>
                      <td><?php echo (isset($post['journeyDaddr']))?$post['journeyDaddr']:'';?></td>
                      <td><?php echo (isset($post['journeyDate']))?$post['journeyDate']:'';?></td>
                      <td><?php echo (isset($post['journeyReturndt']))?$post['journeyReturndt']:'';?></td>
                      <td><?php echo $analytic->source;?></td>
                      <td><?php echo $analytic->keyword;?></td>
                      <td><?php echo $analytic->matchtype;?></td>
                      <td><?php echo $analytic->device;?></td>
                      <td><?php echo $analytic->remote_ip;?></td>
                      <td><?php echo $analytic->distance;?></td>
                      <td><?php echo $analytic->price;?></td>
                      <td><?php echo date('d-M-Y h:i', strtotime($analytic->cdate));?></td>	              
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
<script type="text/javascript">
    var current_date = '<?php echo $current_date; ?>';
</script>