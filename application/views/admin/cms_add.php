<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header">
	<h2>Add or Edit CMS</h2>
</div>
<div class="static-page">
	<div class="bs-example" data-example-id="basic-forms">
		<div id="cmsFormSuccess" class="alert alert-success"
			style="display: none;">
			<strong>Thanks!</strong> for you valuable feedback.
		</div>
		<div id="cmsFormError" class="alert alert-danger"
			style="display: none;">
			<strong>Error! </strong> <span id="cancelErr">Please correct the
				errors.</span>
		</div>
		<form id="cmsForm" class="form-horizontal" method="post" action="<?php echo $action_url; ?>">

    <?php // hidden id ?>
    <?php if (!empty($cms_id)) : ?>
        <?php echo form_hidden('cms_id', $cms->cms_id); ?>
    <?php endif; ?>
		<div id="cmsSlugBlock"
			class="form-group">
			<label for="cmsSlug" class="col-sm-2 control-label">Slug: *</label>
			<div class="col-sm-10">
				<div class="input-group">
				 <span class="input-group-addon">					 
				   </span>
					<input type="text" class="form-control" data-validate="required"
						name="slug" id="cmsSlug" maxlength="100" placeholder="Slug"
						value="<?php echo (!empty($cms->slug) ? $cms->slug : '');?>" />
				</div>
				<span id="cmsSlugSpan" class="help-block"></span>
			</div>

		</div>
		
		<div id="cmsTitleBlock"
			class="form-group">
			<label for="cmsTitle" class="col-sm-2 control-label">Title: *</label>
			<div class="col-sm-10">
				<div class="input-group">
				 <span class="input-group-addon">					 
				   </span>
					<input type="text" class="form-control" data-validate="required"
						name="title" id="cmsTitle" maxlength="100" placeholder="Title"
						value="<?php echo (!empty($cms->title) ? $cms->title : '');?>" />
				</div>
				<span id="cmsTitleSpan" class="help-block"></span>
			</div>
		
		</div>

		<div id="cmsContentBlock" class="form-group">									 
			<label for="cmsContent" class="col-sm-2 control-label">Content: *</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 <!-- span class="glyphicon glyphicon-envelope"></span-->
				   </span>				   
					<textarea id="cmsContent" name="content" class="form-control"
					rows="8" style="resize:none"><?php echo (!empty($cms->content) ? $cms->content : '');?></textarea>		  
				</div>
			   <span id="cmsContentSpan" class="help-block"></span>
			</div>			
		</div>	

			
		<div id="cmsSeoTitleBlock" class="form-group">									 
			<label for="cmsSeoTitle" class="col-sm-2 control-label">Seo Title:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 
				   </span>
				   <input type="text" class="form-control" name="seo_title" id="cmsSeoTitle" maxlength="200" placeholder="SEO Title" value="<?php echo (!empty($cms->page_title) ? $cms->page_title : '');?>"/>
			  
				</div>
			   <span id="cmsSeoTitleSpan" class="help-block"></span>
			</div>			
		</div>
		
		<div id="cmsSeoDescBlock" class="form-group">									 
			<label for="cmsSeoDesc" class="col-sm-2 control-label">Seo Desc:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">					 
				   </span>
				   <input type="text" class="form-control" name="seo_desc" id="cmsSeoDesc" maxlength="225" placeholder="SEO Desc" value="<?php echo (!empty($cms->page_description) ? $cms->page_description : '');?>"/>
			  
				</div>
			   <span id="cmsSeoDescSpan" class="help-block"></span>
			</div>			
		</div>
		
		<div id="cmsSeoKeywordsBlock" class="form-group">									 
			<label for="cmsSeoKeywords" class="col-sm-2 control-label">Seo Keywords:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">					 
				   </span>
				   <input type="text" class="form-control" name="seo_keywords" id="cmsSeoKeywords" maxlength="100" placeholder="SEO Keywords" value="<?php echo (!empty($cms->page_keywords) ? $cms->page_keywords : '');?>"/>
			  
				</div>
			   <span id="cmsSeoKeywordsSpan" class="help-block"></span>
			</div>			
		</div>
		<div class="row pull-right">
			<a class="btn btn-default" href="<?php echo $cancel_url; ?>">Cancel</a>
			<button id="cmsSubmit" type="submit" name="submit" class="btn btn-success">
				<span class="glyphicon glyphicon-save"></span> Save
			</button>
		</div>
		<br/><br/>
		</form>
	</div>
</div>