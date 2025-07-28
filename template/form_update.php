<div class="zipcode_list">
	<?php 
	global $wpdb, $table_prefix;
	$ziplist = $wpdb->get_results("SELECT * FROM ".$table_prefix."posts WHERE post_type = 'cp_zipcode' AND post_parent = '".$post->ID."' AND post_status = 'publish' ORDER BY ID DESC"); 
	
	?>
	<?php if( !$ziplist ) {?>
	<div class="alert alert-primary" role="alert">
        No services available
	</div>
	<?php } ?>
	<?php if( $ziplist ) {?>
	<?php foreach($ziplist as $itemz) { ?>
		
	
   <div class="form-group" id="zipcode_<?php echo $itemz->ID;?>">
			
		<input type="hidden" class="form-control" name="idpriceZip" id="idpriceZip-1" value="<?php echo $itemz->ID;?>">
		<?php 
		global $wpdb, $table_prefix;
		$type = $wpdb->get_results("SELECT * FROM ".$table_prefix."posts WHERE post_type = 'service_type' AND post_status = 'publish'"); 
		?>
		
		<select class="form-control serviceUpdate" name="serviceUpdate" id="serviceUpdate_<?php echo $itemz->ID;?>">
		<?php foreach($type as $service) { ?>
		<?php $srvice = get_post_meta( $itemz->ID, 'service_id', true); ?>
		<?php $selected = ($srvice == $service->ID ) ? 'selected':'';?>
		<option value="<?php echo $service->ID;?>" <?php echo $selected;?>><?php echo $service->post_title;?></option>
		<?php } ?>
		</select>
		<input type="text" value="<?php echo get_post_meta($itemz->ID, 'price_pestzipcode', true);?>" class="form-control" name="pricepest" id="priceZip-1" placeholder="Price">
		<div class="addUpdate" data-num="<?php echo $itemz->ID;?>">Update</div>
		<div class="addDelete" data-num="<?php echo $itemz->ID;?>">Delete</div>
		<div class="message_delete_<?php echo $itemz->ID;?>"></div>
  </div>
	<?php } ?>
	<?php } ?>
 
</div>