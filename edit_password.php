<!Doctype>

	<style>
		body{
			background-image: url(Images/bg.jpg);
		}
	</style>
	
	<html>
		<head>
			<title>Megatesting Inc. Log in</title>
			<link rel="stylesheet" type="text/css" href="CSS/Main_CSS.css">
		</head>
	
	
		<body>
			<div class = "content zoom" id = "content1">
				<form  method="POST" action="editpassIndex.php">
					<div class = "container zoom">
						<br>
						<h1>Edit Password</h1>
						<p><b>Username</b></p>
						<input type="text" placeholder="Enter Username" name="uname" required>
						
						<p><b>Enter New Password</b></p>
						<input type="password" placeholder="Enter Password" name="newpsw" required>
						
						<p><b>Confirm New Password</b></p>
						<input type="password" placeholder="Enter Password" name="conpsw" required>
						
						<br>
						<br>
						
						<button type="submit" class = "btn">Confirm</button>
						<br><a href ="index.html"> Back to log in</a>
						
					</div>
				</form>
			</div>
			
			<div class = "topnav">
				<a style = "color: #f7f7f7;"><b>LOGIN</b></a>
				<a href = "About.html">ABOUT</a>
				<a href = "Help.html">HELP</a>
				<a href = "FAQ.html">F.A.Q.</a>
				
			</div>
			
			
			
			<div class = "end">
				<br><br><p> ___________________________________________________</p>
				<p> Copyright 2018. All Rights Reserved</p>
			</div>
			
			
		
		</body>
	</html>