<?php 
	session_start();
	include 'connection.php'; 
	if(!isset($_SESSION['username'])){
		header('Location: my-account.php');
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
							<a href="qna.php"><li> Discussion Forum </li></a>
						<?php
					}else{
						?>
							<a href="my-account.php"><li> Discussion Forum </li></a>
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
		if(isset($_POST['questionsubmit'])){
			$question =  $conn -> real_escape_string($_POST['question']);
			$username = $_SESSION['username'];
			$sql = "INSERT INTO questions (username, question) VALUES ('$username', '$question')";
			
			if (mysqli_query($conn, $sql)) {
				$msg = '<div class="emsg">Thankyou for asking question.</div>';
				
			}
		}
		
		
		$msg2 = '';
		if(isset($_POST['answersubmit'])){
			$answer =  $conn -> real_escape_string($_POST['answer']);
			$qid =  $conn -> real_escape_string($_GET['single-question']);
			$username = $_SESSION['username'];
			
			$sql = "INSERT INTO answers (username, answer, questionid) VALUES ('$username', '$answer', '$qid')";
			
			if (mysqli_query($conn, $sql)) {
				$msg2 = '<div class="emsg">Thankyou for answering.</div>';
				
			}
		}
	?>
	
	<?php
	
	if(isset($_GET['single-question'])){
		$questionid =  $conn -> real_escape_string($_GET['single-question']);
		$sql = "SELECT question from questions where id='$questionid'";
		$result = $conn->query($sql);
		?>
		<div class="section">
			<div class="container">
				<?php
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						?>
							<h1><?php echo $row['question']; ?></h1>
						<?php
					}
				}
				?>
				<?php echo $msg2; ?>
				
				<div class="answers">
					<?php
						$sql = "SELECT * from answers where questionid = '$questionid' order by id DESC";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								?>
									<div class="single-answer">
										<?php echo $row['answer']; ?>
										<span><?php echo $row['username']; ?></span>
									</div>
								<?php
							}
						}
					?>
					
				</div>
				
				<form method="post" action="#" class="mt-50">
					<textarea placeholder="Answer the question..." name="answer" class="form-control"></textarea>
					<input type="submit" name="answersubmit" class="btn">
					
				</form>
			</div>
		</div>
		<?php
		
	}else{
	?>
		<div class="section">
			<div class="container">
				<form method="post" action="#">
					<h2>Any Question?</h2>
					<textarea placeholder="Ask question..." name="question" class="form-control"></textarea>
					<input type="submit" name="questionsubmit" class="btn">
					<?php echo $msg; ?>
				</form>
			</div>
		</div>
		
		<div class="section">
			<div class="container">
				<h2>Questions Asked</h2>
				<div class="questions-group">
					<?php
						$sql = "SELECT * from questions order by id DESC";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								?>
									<a href="?single-question=<?php echo $row['id']; ?>"><?php echo $row['question']; ?> <br /> <span>Asked by: <i><?php echo $row['username']; ?></i></span></a>
								<?php
							}
						}else{
							echo 'No question asked.';
						}
					?>
				</div>
			</div>
		</div>
	
	<?php
	}
	?>
    <footer>
        &copy; Cyber Crime
    </footer>
 
    
</body>
</html>