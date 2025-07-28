<div id="zipprice">
	<div class="itemzattributes">
		<input type="hidden" class="form-control" name="idpriceZip" id="idpriceZip-1" value="<?php echo $post->ID;?>">
			<?php 
			global $wpdb, $table_prefix;
			$type = $wpdb->get_results("SELECT * FROM ".$table_prefix."posts WHERE post_type = 'service_type' AND post_status = 'publish'"); 
			?>
			 <div class="form-group">
			<label for="titleZip-1">Service</label>
			<select class="form-control" name="serviceType" id="serviceType">
			<?php foreach($type as $itemz) { ?>
			<option value="<?php echo $itemz->ID;?>"><?php echo $itemz->post_title;?></option>
			<?php } ?>
			</select>
			</div>
		  <div class="form-group">
				<label for="priceZip-0">Price</label>
				<input type="text" class="form-control" name="price" id="priceZip-1">
		  </div>
	
	  <div class="some-messages"></div>
	 </div>
	 <div id="pestSave">Add New</div>
</div>


