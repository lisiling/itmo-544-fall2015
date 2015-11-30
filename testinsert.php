<?php

echo "begin database";
$link = mysqli_connect("itmo544lsldb.cpyht2c1c9a4.us-east-1.rds.amazonaws.com","controller","ilovebunnies","itmo544db") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


if (!($stmt = $link->prepare("INSERT INTO student (id, email, phone, filename, s3rawurl, s3finishedurl, status, issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl = $result['ObjectURL']; 
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$status = 0;
$issubscribed = 0;

$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);


if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);


$stmt->close();

$link->real_query("SELECT * FROM student");
$res = $link->use_result();

echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo " id = " . $row['id'] . "\n";
}


$link->close();




?>
