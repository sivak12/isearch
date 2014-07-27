<?php
header("Cache-control: private, no-cache");
header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
header("Pragma: no-cache");

session_start();
session_destroy();
session_start();

$_SESSION['hdr'] = "I Search";
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK REL="SHORTCUT ICON" HREF="logo.ico" />
<script type="text/javascript" src="login_check.js"></script>
<title><?php echo $_SESSION['hdr'] ?></title>
<link type="text/css" rel="stylesheet" href="oats_p3.css" /> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

</head>

<body>

	<div id="all">
		
		<div id="header">
			
			<h1 class="no_br"><?php 
			echo $_SESSION['hdr']."  <span id='ver'>Beta</span>"; 
			echo "<br><span id='sub_hdr'>Intelligent Web Search</span>";?></h1>	
			<!--<h1 class="caption"> Questionnaire</h1>-->
		</div>
		
		<!--<div id="navigation">
			<p id="status"> new user? &nbsp;<a href="register.php">register </a> </p>
		</div>--> 
		
		<div id="login">
			<h1 class="caption">Crawler </h1>
			
			<FORM NAME="Login" ACTION="crawler.php" METHOD=POST>
			<table>
				
				<tr>
					<th>
						Enter Site:	
					</th>
					<td>
						<INPUT ID="name" TYPE="TEXT" NAME="txtName" VALUE="" SIZE="30" />
					</td>
				</tr>
					
				<tr>
					<th>
					</th>
					<td>
						<input type="submit" value="Crawl" />
					</td>
					
				</tr>
			
			</table>
		
		
		</form>
		
		</div>
		
		<div id="footer">
				  <p><?php if ($Err) { ?>
			<div align="center"><label><p><b>Wrong Username/password.Try again.</b></p></label></div>
		<?php } ?></p>
		</div>
	</div> 

</body>

</html>
