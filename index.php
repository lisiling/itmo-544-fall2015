<?php session_start(); ?>
<html>
<head>

<style type="text/css">
body{
        padding: 0px;
        margin: 0px;
        background: #EFDBC0;
}
header{
        background: #080808;
        opacity: 0.9;
        width: 100%;
        height: 100px;
        margin-right: 0px;
}
img.logo{
        position: fixed;
        width: 130px;
        height: 80px;
}
ul.second-nav{
	list-style-type: none;
	position: relative;
	margin-left: 550px;
	width: 1000px;
	
}
ul.second-nav li{
	position: relative;
	width: 150px;
	height: 40px;
	float:left;
	color: #D5D2CE;
	font-size: 18px;
	font-family:'Miltonian Tattoo', cursive;
	margin-top: 20px;
	margin-right: 10px;
	text-align: center;
}
ul.second-nav li:hover{
	color: #AD8148;
}
#content{
    font-family: 'Titillium Web', sans-serif;
    font-size: 20px;
    margin-top: 40px;
    margin-left: 20px;
    text-align: center;
    color: #272625;
}
#second-content{
	font-family: 'Roboto', sans-serif;
	font-size: 17px;
	text-align: center;
	color: #393836;
}
</style>

<title>Welcome to Siling's Page</title>
</head>
<body>

<header>
	<div id="header-container">
		<img class="logo" src="images/gallery-art.jpg"><div id="name">Index</div>
		<ul class="second-nav">
			<a href="logup.php"><li>log up</li></a>
			<a href="login.php"><li>log in</li></a>
		</ul>
	</div>
</header>

<div id="content">

<form enctype="multipart/form-data" action="result.php" method="POST">
   
<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

Send this file: <input name="userfile" type="file" /><br />
Enter Email of user: <input type="email" name="useremail"><br />
Enter Phone of user (1-XXX-XXX-XXXX): <input type="phone" name="phone">

<input type="submit" value="Send File" />
</form>
<hr />

<form enctype="multipart/form-data" action="gallery.php" method="POST">

Enter Email of user for gallery to browse: <input type="email" name="email">
<input type="submit" value="Load Gallery" />
</form>

</div>

<!-- 
<div id="content">
<a href="introspection.php"><li>Backup databases</li></a>
</div>
 -->

</body>
</html>
