<?php
	require 'vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	include('aws-config.php');
	
	// Connect to AWS
	try {
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => $REGION
			)
		);
	} catch (Exception $e) {
		header('Location: ' . $RedirectURL . '?result=failed&f=' . $folder);
		die("Error: " . $e->getMessage());
	}

	// Folder is Demo for Now (Will make it get from user)
	$folder = $_POST['directory'];

	$keyName = $folder . basename($_FILES["fileToUpload"]['name']);
	$pathInS3 = 'https://s3.' . $REGION . '.amazonaws.com/' . $bucketName . '/' . $keyName;

	// Add it to S3
	try {
		// Uploaded:
		$file = $_FILES["fileToUpload"]['tmp_name'];

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

	} catch (S3Exception $e) {
		header('Location: ' . $RedirectURL . '?result=failed&f=' . $folder);
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		header('Location: ' . $RedirectURL . '?result=failed&f=' . $folder);
		die('Error:' . $e->getMessage());
	}
	header('Location: ' . $RedirectURL . '?result=success&f=' . $folder);
?>