<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header">
	<h2>Rides - dashboard</h2>
</div>
<div class="static-page">
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6 text-left">                
                <div id="cmsFormSuccess" class="alert alert-success"
					<?php echo (empty($message))?'style="display: none;"':''; ?>>
					<strong>Thanks!</strong> <?php echo $message; ?>.
				</div>
				<div id="cmsFormError" class="alert alert-danger"
					<?php echo (empty($error))?'style="display: none;"':''; ?>>
					<strong>Error! </strong> <span id="cancelErr"><?php echo $error; ?>.</span>
				</div>
            </div>
            <!--div class="col-md-6 text-right">
                <a class="btn btn-success tooltips" href="<?php echo base_url('admin/rides/add'); ?>" title="Add new Content" data-toggle="tooltip"><span class="glyphicon glyphicon-plus-sign"></span> Add Content</a>
            </div-->
        </div>
    </div>

    <table class="table table-striped table-hover-warning">
        <thead>

            <?php // sortable headers ?>
            <tr>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=ride_name&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Ride</a>
                    <?php if ($sort == 'ride_name') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=per_km&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Per Km</a>
                    <?php if ($sort == 'per_km') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=actual_per_km&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Actual km</a>
                    <?php if ($sort == 'actual_per_km') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=seats&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Seats</a>
                    <?php if ($sort == 'seats') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=first_name&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Vendor</a>
                    <?php if ($sort == 'first_name') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=city_name&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Location</a>
                    <?php if ($sort == 'city_name') : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <td>
                    <a href="#">Contact</a>                    
                </td>                
                <td>
                    <a href="#">SMS</a>                    
                </td>
                <td class="pull-right">
                    Action
                </td>
                
            </tr>

            <?php // search filters ?>
            <tr>
                <?php echo form_open(current_url() . "?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
                    <th<?php echo ((isset($filters['ride_name'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'ride_name', 'id'=>'ride_name', 'class'=>'form-control input-sm', 'placeholder'=> 'Ride', 'value'=>set_value('ride_name', ((isset($filters['ride_name'])) ? $filters['ride_name'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['per_km'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'per_km', 'id'=>'per_km', 'class'=>'form-control input-sm', 'placeholder'=> 'Km', 'value'=>set_value('per_km', ((isset($filters['per_km'])) ? $filters['per_km'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['actual_per_km'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'actual_per_km', 'id'=>'actual_per_km', 'class'=>'form-control input-sm', 'placeholder'=> 'Actual', 'value'=>set_value('actual_per_km', ((isset($filters['actual_per_km'])) ? $filters['actual_per_km'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['seats'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'seats', 'id'=>'seats', 'class'=>'form-control input-sm', 'placeholder'=> 'Seats', 'value'=>set_value('seats', ((isset($filters['seats'])) ? $filters['seats'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['first_name'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'first_name', 'id'=>'first_name', 'class'=>'form-control input-sm', 'placeholder'=>'Name', 'value'=>set_value('first_name', ((isset($filters['first_name'])) ? $filters['first_name'] : '')))); ?>
                    </th>
                    <th<?php echo ((isset($filters['city_name'])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=>'city_name', 'id'=>'city_name', 'class'=>'form-control input-sm', 'placeholder'=>'City', 'value'=>set_value('city_name', ((isset($filters['city_name'])) ? $filters['city_name'] : '')))); ?>
                    </th>
                    <th>                       
                    </th>                    
                    <th colspan="3">
                        <div class="text-right">
                            <a href="<?php echo $this_url; ?>" class="btn btn-danger tooltips" data-toggle="tooltip" title="Reset"><span class="glyphicon glyphicon-refresh"></span></a>
                            <button type="submit" name="submit" value="Filter" class="btn btn-success tooltips" data-toggle="tooltip" title="Filter"><span class="glyphicon glyphicon-filter"></span></button>
                        </div>
                    </th>
                <?php echo form_close(); ?>
            </tr>

        </thead>
        <tbody>

            <?php // data rows ?>
            <?php if ($total) :
                    //print_r($pages);
                ?>
                <?php foreach ($pages as $page) : ?>
                    <tr>
                        <td<?php echo (($sort == 'ride_name') ? ' class="sorted"' : ''); ?>>
                            <?php echo $page->ride_name; ?>
                        </td>
                        <td<?php echo (($sort == 'per_km') ? ' class="sorted"' : ''); ?>>
                            <?php echo $page->per_km; ?>
                        </td>
                        <td<?php echo (($sort == 'actual_per_km') ? ' class="sorted"' : ''); ?>>
                            <?php echo $page->actual_per_km; ?>
                        </td>
                        <td<?php echo (($sort == 'seats') ? ' class="sorted"' : ''); ?>>
                            <?php echo $page->seats; ?>
                        </td>
                        <td<?php echo (($sort == 'first_name') ? ' class="sorted"' : ''); ?>>
                             <?php echo $page->first_name . ' '. $page->last_name; ?>
                        </td>
                        <td<?php echo (($sort == 'city_name') ? ' class="sorted"' : ''); ?>>
                             <?php echo $page->city_name ; ?>
                        </td>
                        <td<?php echo (($sort == 'phone') ? ' class="sorted"' : ''); ?>>
                             <?php echo $page->phone ; ?>
                        </td>                        
                        <td >
                            <a href="<?php echo $this_url; ?>/sms_partner/<?php echo $page->vendor_id; ?>/<?php echo $page->order_id; ?>">sendride</a>
                        </td>
                        <td>
                            <div class="text-right">
                                <div class="btn-group">
                                    <?php if ($page->ride_id > 1) : ?>
                                        <a href="#modal-<?php echo $page->ride_id; ?>" data-toggle="modal" class="btn btn-danger" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                                    <?php endif; ?>
                                    <a href="<?php echo $this_url; ?>/add/<?php echo $page->ride_id; ?>" class="btn btn-warning" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">
                        No results
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <?php // list tools ?>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-2 text-left">
                <label><?php echo 'Total:' . $total; ?></label>
            </div>
            <div class="col-md-2 text-left">
                <?php if ($total > 10) : ?>
                    <select id="limit" class="form-control">
                        <option value="10"<?php echo ($limit == 10 OR ($limit != 10 && $limit != 25 && $limit != 50 && $limit != 75 && $limit != 100)) ? ' selected' : ''; ?>>10 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="25"<?php echo ($limit == 25) ? ' selected' : ''; ?>>25 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="50"<?php echo ($limit == 50) ? ' selected' : ''; ?>>50 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="75"<?php echo ($limit == 75) ? ' selected' : ''; ?>>75 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="100"<?php echo ($limit == 100) ? ' selected' : ''; ?>>100 <?php echo lang('admin input items_per_page'); ?></option>
                    </select>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php echo $pagination; ?>
            </div>
            <div class="col-md-2 text-right">
                <?php if ($total) : ?>
                    <a href="<?php echo $this_url; ?>/export?sort=<?php echo $sort; ?>&dir=<?php echo $dir; ?><?php echo $filter; ?>" class="btn btn-success tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip csv_export'); ?>"><span class="glyphicon glyphicon-export"></span> <?php echo lang('admin button csv_export'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php // delete modal ?>
<?php if ($total) : ?>
    <?php foreach ($pages as $page) : ?>
        <div class="modal fade" id="modal-<?php echo $page->ride_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-label-<?php echo $page->ride_id; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="modal-label-<?php echo $page->ride_id; ?>"> Page delete</h4>
                    </div>
                    <div class="modal-body">
                        <p>Confirm delete <?php echo $page->ride_id; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-delete-user" data-id="<?php echo $page->ride_id; ?>">delete</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>