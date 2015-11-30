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
require 'vendor/autoload.php';
$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$result = $rds->describeDBInstances([
   'DBInstanceIdentifier' => 'lsldb',
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
    echo "============\n". $endpoint . "================";
    
$link = mysqli_connect($endpoint,"lisiling","ilovebunnies","itmo544mp1") or die("Error " . mysqli_error($link));
    
   $dbhost = '$endpoint:3306';
   $dbuser = 'lisiling';
   $dbpass = 'ilovebunnies';
   
   $conn = mysql_connect($endpoint,'lisiling', 'ilovebunnies',"itmo544mp1")or die ('Error connecting to mysql');
   
   $dbname = 'itmo544mp1';
   mysql_select_db('$dbname');
   
   $table_name = "items";
   $backup_file  = "/tmp/lisiling.sql";
   $sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";
   $result = mysql_query($query);
   
   mysql_close($conn);
?>
</div>


</body>
</html>