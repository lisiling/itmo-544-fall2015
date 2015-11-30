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
<title>Gallery</title>
</head>




<body>

<header>
<br/>
	<p>Welcome to Siling's Page</p>
</header>

<div id="content">

<?php
session_start();

$email = $_POST["email"];
require 'vendor/autoload.php';
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
 'version'=>'latest',
'region'  => 'us-east-1'
));
$result = $client->describeDBInstances([
   'DBInstanceIdentifier' => 'lsl-db',
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
    echo "============\n". $endpoint . "================";
$link = mysqli_connect($endpoint,"lisiling","ilovebunnies","itmo544mp1") or die("Error " . mysqli_error($link));
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
echo "\n" . $email . "gallery\n";


$link->real_query("SELECT * FROM items WHERE email = '$email'");

$res = $link->use_result();
echo "Result...\n";
while ($row = $res->fetch_assoc()) {
    echo "<img src =\" " . $row['s3rawurl'] . "\" /><img src =\"" .$row['s3finishedurl'] . "\"/>";
echo $row['id'] . "Email: " . $row['email'];
}
$link->close();
?>

</div>
</body>
</html>