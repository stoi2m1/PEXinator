<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Install</title>

<style type="text/css">

body,html
{
	padding: 0px;
	margin: 0px;	
}
body
{
	background: url(../img/body_bg.png);
	font-family:Verdana, Geneva, sans-serif;
	color: #fff;
	font-size:12px;
}
#wrapper
{
	width: 900px;
	margin: auto;	
	
	
}


input[type='text'], input[type='password'], input[type='email'], select
{
	background: #111;
	color: #fff;
	padding: 8px;
	border: none;	
	border-radius: 5px;
	box-shadow: 0px 1px 1px #333;
	width: 200px;
	margin-top: 5px;
}

input[type='submit']
{
	background: #111;
	color: #fff;
	padding: 8px;
	border-radius: 5px;
	box-shadow: 1px 1px 1px #333;
	border: none;
	cursor: pointer;
	margin-top: 5px;
}
input:hover
{
	background: #000;		
}
#logo
{
	width: auto;
	text-shadow: 0px 1px 1px #333;
	color: #111;
	font: 70px 'impact';
	margin-top: 100px;
}
#logo .the
{
	font: 45px 'impact';
	margin-top: 100px;
}
h1
{
	font-family:Verdana, Geneva, sans-serif;
	color: #fff;
	margin: 2px;
	font-size:16px;	
}

.error
{
	width: auto;
	padding: 10px;
	background:#FF464A;
	border: 1px solid #FF0000;
	-moz-border: 1px solid #FF0000;
	-webkit-border: 1px solid #FF0000;
	margin: 20px;

	font-weight: bold;
}

.success
{
	width: auto;
	padding: 10px;
	background:#2CAE00;
	border: 1px solid #0F0;
	-moz-border: 1px solid #0F0;
	-webkit-border: 1px solid #0F0;
	margin: 20px;

	font-weight: bold;
}
a
{
	color: #fff;
	text-decoration:underline;	
}
</style>



</head>
<body>

<div id="wrapper">


	<header>
    	<div id="logo">
        	<span class="the">the</span>Pexinator - Install
        </div>
    </header>

	

<?php if(!isset($_GET['step'])) { ?>

	<h1>Step 1 - MySQL Connection info</h1>
    
    <?php if(isset($_GET['error'])) { ?>
    <div class="error">Error: <?php echo $_GET['error']; ?></div>
    <?php } ?>
    
    
	<form action="process.php" method="POST">
    	<input type="text" value="localhost" name="server"/> MySQL Server<br />
        <input type="text" value="root" name="user"/> MySQL User<br />
        <input type="text" placeholder="Password..." name="password"/> MySQL Password<br />
        <input type="text" value="pex" name="db" /> PermissionsEX Database<br />
        <input type="hidden" name="source" value="mysql" />
		<input type="submit" value="Next Step >>" name="submit" />
    </form>

<?php } elseif ($_GET['step'] == 2) { ?>

	<h1>Step 2 - Admin Info</h1>
    
    <?php if(isset($_GET['error'])) { ?>
    <div class="error">Error: <?php echo $_GET['error']; ?></div>
    <?php } ?>
    
    <?php if(isset($_GET['success'])) { ?>
    <div class="success">Successfully connected to MySQL :: Continue installation below</div>
    <?php } ?>
    
	<form action="process.php" method="POST">
    	<input type="text" placeholder="Username..." name="username"/> Used to login into panel<br />
        <input type="password" placeholder="Password..." name="pass1"/> Create a Password<br />
        <input type="password" placeholder="Confirm Password..." name="pass2"/> Confirm Password<br />
        <input type="text" placeholder="Secret Pin..." name="pin" maxlength="4" /> Create a 4 digit numeric PIN<br />
        <input type="hidden" name="source" value="admin" />
		<input type="submit" value="Next Step >>" name="submit" />
    </form>
    
<?php } elseif($_GET['step'] == 3) { ?>

<h1>Installation Complete!</h1>
You must delete the entire INSTALL directory to continue using thePexinator.<br />
Do that, then <a href="../index.php">LOGIN</a>.
<br />


<?php } ?>	


</div>





</body>
</html>