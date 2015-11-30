<html>
<head>

<style type="text/css">
body{
        position: relative;
        text-align: center;
        opacity: 0.8;
        width:1001px;
        height:100%;
        padding: 0px;
        margin: 0px;
        background: lightyellow;
}
header{
        background: blue;
        font-size: 30px;
        text-align: center;
        color: lightyellow;
        text-shadow: 0 0 8px black;
        opacity: 0.8;
        width: 100%;
        height: 140px;
        margin-right: 0px;
}
#content{
    font-size: 20px;
    margin-top: 40px;
    margin-left: 20px;
    text-align: center;
    color: blue;
    text-shadow: 0 0 6px lightblue;
}
</style>

<title>index</title>
</head>

<body>

<header>
<br/>
	<p>Welcome to Siling's Page</p>
</header>

<div id="content">

<br/><br/>
<?php

session_start();
$useremail = $_POST["useremail"];
echo $_POST['useremail'];
$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
       echo "File is valid, and was successfully uploaded.\n";}
else{
echo "Possible file upload attact!\n";}

echo 'Here is some more debugging info:';
print_r($_FILES);
print "</pre>";
require 'vendor/autoload.php';
use Aws\S3\S3Client;
$client = S3Client::factory(array(
'version' => 'latest',
'region' => 'us-east-1'
));

$bucket = uniqid("php-lsl-",false);
$result = $client->createBucket(array(
    'Bucket' => $bucket
));


$client->waitUntil('BucketExists',array('Bucket' => $bucket));
$key = $uploadfile;
$result = $client->putObject(array(
'ACL' => 'public-read',
'Bucket' => $bucket,
'Key' => $key,
'SourceFile' => $uploadfile
));


$url = $result['ObjectURL'];
echo $url;

use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'version' =>'latest',
'region' => 'us-east-1'
));

$result = $rds->describeDBInstances([
   'DBInstanceIdentifier' => 'lsl-db',

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
    echo "============\n". $endpoint . "================";

$link = mysqli_connect($endpoint,"lisiling","ilovebunnies","itmo544mp1") or die("Error" . mysqli_error($link));

/* check connection */
if (myaqli_connect_error()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}

/* prepared statement, stage 1:prepare */
if (!($stmt = $link->prepare("INSERT INTO items (id, email, phone, filename, s3finishedurl, status, issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))){
echo "Prepare failed: (" . $link->errno . ")" . $link->error;
}

$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl =$url; 
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = $finishedurl;
$status = 0;
$issubscribed = 0;
$password = $_POST["password"];

$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);

if (!$stmt->execute()) {
echo "Execute failed: (" . $stmt->errno . ") " .$stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);

/* explicit close recommended */
$stmt->close();

$link->real_query("SELECT * FROM items");
$res = $link->use_result();

echo "Result...\n";
while ($row = $res->fetch_assoc()) {
echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}

$link->close();

?>
</div>


</body>
</html>