<?php 

 global $wpdb, $table_prefix;
	 
	  if($_GET['delete'] == true){
		$table_name = $wpdb->prefix . 'pestmarshals_person';
		$delete = $wpdb->delete( 
				$table_name, 
				array( 
					'id' => $_GET['delete']
				),
				array('%s') 
			);
	 }
	 
	 if($_GET['y'] == 'delete') {
		$delete = $wpdb->query("TRUNCATE ".$table_prefix."pestmarshals_person");
		wp_redirect( get_bloginfo('wpurl').'/wp-admin/admin.php?page=schedule_servicejs' );
	}
	 
	$limit = 40;
	$currentPage = 1;
	if(isset($_GET['next'])){
	$currentPage = $_GET['next'];
	}
	$startPage = 1;
	$start = ($startPage < 0) ?  0 : ($currentPage-1) * $limit;
	echo '<div class="wrap">';
	echo '<h2>Pest Marshals List</h2>';
	
	echo '<div>';
	echo '<form style="float: right;margin-left: 10px;" method="post" action="'.get_bloginfo('url').'">';
	echo '<input type="hidden" name="download_csv" value="csv">';
	echo '<input type="number" name="qty_search" min="20" value="20">';
	echo '<input type="submit" value="Download CSV">';
	echo '</form>';
	 echo '<a  style="float: right;padding: 6px;display: block;border: 1px solid #dadada;width: 4%;text-align: center;margin-bottom: 10px;text-decoration: none;border-radius: 3px;background-color: #dadada;color: #000;font-weight: 600;" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=schedule_servicejs&y=delete">Empty</a>';
	 echo '</div>';
	 echo '<table style="border-collapse: collapse; width: 100%;">
			  <tr>
				<th style="text-align: left;border: 1px solid #dddddd;padding: 8px;">Remove</th>
				<th style="text-align: left;border: 1px solid #dddddd;padding: 8px;">Full Name</th>
				<th style="text-align: left;border: 1px solid #dddddd;padding: 8px;">Email Address</th>
				<th style="text-align: left;border: 1px solid #dddddd;padding: 8px;">Phone Number</th>
				<th style="text-align: left;border: 1px solid #dddddd;padding: 8px;">Zip</th>
				<th style="text-align: left;border: 1px solid #dddddd;padding: 8px;">Customer ID</th>
			  </tr>';
			
		$ky = $wpdb->get_results("SELECT * FROM ".$table_prefix."pestmarshals_person ORDER BY id DESC LIMIT $start, $limit"); 
		 foreach($ky as $vt) {
				echo '<tr>';
				echo '<td style="text-align: left;width:20px;border: 1px solid #dddddd;padding: 8px;"><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=schedule_servicejs&delete='.$vt->id.'">Delete</a></td>';
				echo '<td style="text-align: left;border: 1px solid #dddddd;padding: 8px;">'.$vt->first_name.'&nbsp;'.$vt->last_name.'</td>';
				echo '<td style="text-align: left;border: 1px solid #dddddd;padding: 8px;">'.$vt->email_address.'</td>';
				echo '<td style="text-align: left;border: 1px solid #dddddd;padding: 8px;">'.$vt->phone.'</td>';
				echo '<td style="text-align: left;border: 1px solid #dddddd;padding: 8px;">'.$vt->zipcode.'</td>';
				echo '<td style="text-align: left;border: 1px solid #dddddd;padding: 8px;">'.$vt->CustomerID.$vt->id.'</td>';
				echo '<tr>';
		 }
		echo '</table>';
		
			
		/***Fake Record**/
		
		echo '</div>';	 

?>