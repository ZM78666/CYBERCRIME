<?php 
	session_start();
	include 'connection.php'; 
	if(isset($_SESSION['username'])){
		header('Location: qna.php');
		exit;
	}
	
	if(isset($_GET['signout'])){
		unset($_SESSION['username']);
		header('Location: my-account.php');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prevention of Cybercrime</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" >
</head>
<body>

   
    <header>
        <div class="leftHeader"><span>Cyber Crime</span></div>
        <div class="rightHeader">
            <ul>
                <a href="index.html"><li>Home</li></a>
                <a href="cases-of-cybercrime.html"><li>Cases of Cybercrime</li></a>
                <a href="prevention-of-cybercrime.html"><li>Prevention of Cybercrime</li></a>
                <a href="review/index.html"><li>Review</li></a>
				<?php
					
					
					if(isset($_SESSION['username'])){
						?>
							<a href="qna.php"><li>My Account</li></a>
						<?php
					}else{
						?>
							<a href="my-account.php"><li>My Account</li></a>
						<?php
					}
					
					if(isset($_SESSION['username'])){
						?>
							<a href="?signout=out"><li>Signout</li></a>
						<?php
					}
				?>
                
            </ul>
        </div>
    </header>

	<?php
		$msg = '';
		$username = '';
		$fullname = '';
		$mail = '';
		$password = '';
		
		if(isset($_POST['signupsubmit'])){
			$username =  $conn -> real_escape_string($_POST['username']);
			$fullname =  $conn -> real_escape_string($_POST['fullname']);
			$mail =  $conn -> real_escape_string( $_POST['mail']);
			$password =  $conn -> real_escape_string( $_POST['password']);
			$password = password_hash($password, PASSWORD_DEFAULT);
			
			$sql = "SELECT email from register_users where email = '$mail'";
			$result = mysqli_query($conn, $sql);
			
			$sql2 = "SELECT username from register_users where username = '$username'";
			$result2 = mysqli_query($conn, $sql2);
			
			
			
			if (mysqli_num_rows($result) > 0) {
				$msg = '<div class="emsg">Email already taken.</div>';
			}else if (mysqli_num_rows($result2) > 0) {
				$msg = '<div class="emsg">Username already taken try other username.</div>';
			}else{
				$sql = "INSERT INTO register_users (username, name, email, password) VALUES ('$username', '$fullname','$mail', '$password')";
				if (mysqli_query($conn, $sql)) {
					
					$msg = '<div class="emsg">Thankyou for signing up, you can login.</div>';
					$username = '';
					$fullname = '';
					$mail = '';
					$password = '';
				}	
			}
		}
		
		
		$msglogin = '';
		if(isset($_POST['loginsubmit'])){
			$username = $conn->real_escape_string($_POST['username']);
			$passwordlogin = $conn->real_escape_string($_POST['password']);
			
			$sql = "SELECT * FROM register_users WHERE username = '$username'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				if (password_verify($passwordlogin, $row['password'])) {
					$_SESSION['username'] = $row['username'];
					header('Location: qna.php');
					exit(); 
				} else {
					$msglogin = '<div class="emsg">Incorrect login credentials.</div>';
				}
			} else {
				$msglogin = '<div class="emsg">Incorrect login credentials.</div>';
			}
		}

	?>
	<div class="section">
		<div class="container">
			<div class="two-col">
				<div>
					<form method="post" action="#">
						<h2>Login</h2>
					
						<label>Username</label>
						<input type="text" name="username" class="form-control" required>
						
						
						<label>Password</label>
						<input type="password" name="password" class="form-control"  required>
						
						<input type="submit" name="loginsubmit" class="btn">
						<?php echo $msglogin; ?>
					</form>
				</div>
				
				<div>
					<form method="post" action="#">
						<h2>Signup</h2>
					
						<label>Username</label>
						<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
						
						<label>Full Name</label>
						<input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>" required>
						
						<label>Email</label>
						<input type="email" name="mail" class="form-control" value="<?php echo $mail; ?>" required>
						
						<label>Password</label>
						<input type="text" name="password" class="form-control" value="<?php echo $password; ?>" required>
						
						<input type="submit" name="signupsubmit" class="btn">
						<?php echo $msg; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
    <footer>
        &copy; Cyber Crime
    </footer>
 
    
</body>
</html>