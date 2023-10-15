<?php
define('REGION', 'ap-southeast-2');
define('S3_BASE_URL','https://mytapproject.s3.amazonaws.com/');
define('accessKey', 'AKIA6PWUECU5UXC5WZ6C');
define('secret', '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');
require dirname(dirname(__FILE__)).'/aws/aws-autoloader.php';
//use Aws\Common\Exception\MultipartUploadException;
//use Aws\S3\MultipartUploader;
use Aws\S3\S3Client; 


	if(isset($_POST["submit"])){
		$file_name = basename($_FILES['userfile']['name']);   
		$file_type = pathinfo($file_name, PATHINFO_EXTENSION); 
		$allowTypes = array('pdf','jpg','png','jpeg','doc','docx'); 
		if(in_array($file_type, $allowTypes)){ 
            // File temp source 
            $temp_file_location = $_FILES["userfile"]["tmp_name"];
		  $s3 = new Aws\S3\S3Client([
			'region'  => REGION,
			'version' => 'latest',
			'credentials' => [ 
				'key'    => accessKey, 
				'secret' => secret, 
			 ] 
		   ]);		

        $result = $s3->putObject([
            'Bucket' => 'mytapproject',
            'Key' => $file_name,
			'SourceFile' => $temp_file_location
        ]);
		$result_data = array(
		   "photoURL" => $result["ObjectURL"],
		   "fileName" => $file_name
		);
		$response_data = array( 
			"Message" => "File succesfully uploaded",
			"data" => $result_data
		);
			
	}else { $response_data = array(
		"Message" => "You can only upload 'pdf','jpg','png','jpeg','doc','docx' files."
	);}
	} else {$response_data = array(
		"Message" => "Something went wrong."
	);}

	header('Content-Type: application/json');
	echo json_encode($response_data);
?>