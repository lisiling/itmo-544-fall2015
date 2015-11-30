<?php session_start(); ?>
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
<form enctype="multipart/form-data" action="result.php" method="POST">
   
<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

Send this file: <input name="userfile" type="file" /><br /><br/>
Enter Email of user: <input type="email" name="useremail"><br /><br/>
Enter Phone of user (1-XXX-XXX-XXXX): <input type="phone" name="phone">

<input type="submit" value="Send File" />
</form>

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
