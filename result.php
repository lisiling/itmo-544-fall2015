<?php
//Start the session
session start();
//In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
//of $_FILES.

echo $_POST['useremail'];

$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
echo "File is valid, and was successfully uploaded.\n";
else{
echo "Possible file upload attact!\n";

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";
require 'vendor/autoload.php';
use Aws\S3\S3Client;

$client = S3Client::factory();
$s3 = new Aws\S3\S3Client([
'version' => 'latest',
'region' => 'us-east-1'
]);

$bucket = uniqid("php-lsl-",false);

#$result = $client->createBucket(array(
#'Bucket' => $bucket
#));
# AWS PHP SDK version 3 create bucket
$result = $s3->createBucket([
'ACL' => 'public-read',
'Bucket' => $bucket
)];

#$client->waitUntilBucketExists(array('Bucket' => $bucket));
#Old PHP version 2
#Skey = $uploadfile;
#$result = $client->putObject(array(
#'ACL' => 'public-read',
#'Bucket' => $bucket,
#'Key' => $key,
#'SourceFile' => $uploadfile
#));

#PHP version 3
$result = $client->putObject([
'ACL' => 'public-read',
'Bucket' => $bucket,
'Key' => $uploadfile
)];


$url = $result['ObjectURL'];
echo $url;

use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'region' => 'us-east-1'
));
$result = $client->describeDBIntances(array(
'DBInstanceIdentifier' => 'itmo544lsldb',
));

$endpoint = "";

foreach ($result->getPath('DBInstances/*/Endpoint/Address') as $ep) {
//Do something with the message
echo "============". $ep . "================";
$endpoint = $ep;
}
//echo "begin database";
$link = mysqli_connect($endpoint,"controller","ilovebunnies","itmo544db") or die("Error" . mysqli_error($link));

/* check connection */
if (myaqli_connect_error()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}

/* prepared statement, stage 1:prepare */
if (!($stmt = $link->prepare("INSERT INTO items (id, email, phone, filename, s3finishedurl, status, issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))){
echo "Prepare failed: (" . $link->errno . ") . $link->error;
}

$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl =$url; // $result['ObjectURL']; from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$status = 0;
$issubscribed = 0;

$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);

if (!$stmt->execute()) {
echo "Execute failed: (" . $stmt->errno . ") " .$stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);

/* explicit close recommended */
$stmt->close();

$link->real_query("SELECT * FROM items");
$res = $link->use_result();

echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}

$link->close();

?>
