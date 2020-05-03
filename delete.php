<?php
	include("connection.php");
	if(empty($_SESSION['user_id']) || empty($_SESSION['googleVerifyCode'])){
		header("Location: " . $APP_URL . 'dashboard');
		die();
	}

	require 'vendor/autoload.php';
	
	if(!isset($_POST['directory'])){
		header("Location: " . $APP_URL . 'dashboard');
		die();
	}
	$folder = $_POST['directory'];
	
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

	$keyname = $_POST['keyName'];

	// Delete the object from the bucket.
	try
	{
		echo 'Attempting to delete ' . $keyname . '...' . PHP_EOL;

		$result = $s3->deleteObject([
			'Bucket' => $bucketName,
			'Key'    => $keyname
		]);

		if ($result['DeleteMarker'])
		{
			echo $keyname . ' was deleted or does not exist.' . PHP_EOL;
		} else {
			header('Location: ' . $RedirectURL . '?result=failed&f=' . $folder);
			exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
		}
	}
	catch (S3Exception $e) {
		header('Location: ' . $RedirectURL . '?result=failed&f=' . $folder);
		exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
	}
	header('Location: ' . $RedirectURL . '?result=success&f=' . $folder);
?>