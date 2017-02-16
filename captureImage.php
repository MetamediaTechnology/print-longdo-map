<?php

	$output = array();

	try {
		$folder_file_upload = "output/";
		$file_name = 'img_'.date('Ymd_His').rand().'.png';
		$full_file_name = $folder_file_upload . $file_name;
		if(!file_exists($folder_file_upload)){
			mkdir($folder_file_upload, 0777, true);
		}
    
		$img_str = $_REQUEST['image'];
		$img = base64_decode(substr($img_str, strpos($img_str, ",") + 1));
		file_put_contents($full_file_name, $img);
		$output = array('status' => 'SUCCESS', 'filename' => $full_file_name, 'message' => 'Success to upload image');
	
  } catch (Exception $e) {
		$output = array('status' => 'ERROR', 'filename' => $full_file_name, 'message' => $e->getMessage());
	
  }

	if(isset($_REQUEST['callback'])) {
		echo $_REQUEST['callback'].'('.json_encode($output).');';
	} else {
		echo json_encode($output);
	}

?>