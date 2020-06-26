
<?php
	session_start();

	include('../dbconnect.php');
	
	// Register
	if (isset($_POST['submit'])) 
	{
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$fullname = mysqli_real_escape_string($db, $_POST['fullname']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		$confirmPassword = mysqli_real_escape_string($db, $_POST['confirmPassword']);
		
		if($password==$confirmPassword)
		{
			$pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
			if(preg_match($pattern, $password))
			{
				$query = "SELECT * FROM students WHERE username='$username'";
				$results = mysqli_query($db, $query);
				$row = mysqli_fetch_assoc($results);
				if (mysqli_num_rows($results) == 0)
				{
					$password = md5($password);
					$query = "INSERT INTO students (username, fullname, email, password) VALUES('$username', '$fullname', '$email', '$password')";
					mysqli_query($db, $query);
					$_SESSION['username'] = $username;
					header('location: settings.php');
				}
				else
				{
					$usernameError = "Username already exists";
				}
			}
			else
			{
				$passwordError = "Invalid Password";
			}
		}
		else
		{
			$passwordError = "Passwords don't match";
		}
	}
	  
?>

<!------------------------------------------------------------>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Register</title>
  <!--BootStrap-->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <!--JavaScript-->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <style>
	body, html {
	  font-family: Arial, Helvetica, sans-serif;
	  background-image:url(../images/bg.jpg);
	  background-position: center;
      background-repeat: repeat;
	  background-attachment: fixed;
      background-size: cover !important;
	  height: auto;
      width: 100%;
	}
    .container{
		margin-top: 4%;
		max-width: 450px;
	}
	.hr{
		width: 50px;
		height: 2px;
		background-color: #00d1b5;
	}
  </style>
</head>

<body>
  <div class="container shadow p-4 mb-4 bg-white">
	<div class="text-dark text-center alert">
	  <h5>Register</h5>
	  <hr class="hr">
	</div>
	<form action="" method="POST">
	  <div class="form-group row">
		<label for="username" class="col-sm-4 col-form-label">Username</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
		  <?php	if(isset($usernameError)) {?>
			<small class="text-danger"><i class="fa fa-fw fa-exclamation-circle"></i><strong><?php echo $usernameError; ?></strong></small>
		  <?php } ?>
		</div>
	  </div>
	  <div class="form-group row">
		<label for="fullname" class="col-sm-4 col-form-label">Full Name</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="fullname" value="<?= isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>" required>
		</div>
	  </div>
	  <div class="form-group row">
		<label for="email" class="col-sm-4 col-form-label">Email</label>
		<div class="col-sm-8">
		  <input type="email" class="form-control" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
		  <?php	if(isset($emailError)) {?>
			<small class="text-danger"><i class="fa fa-fw fa-exclamation-circle"></i><strong><?php echo $emailError; ?></strong></small>
		  <?php } ?>
		</div>
	  </div>
	  <div class="form-group row">
		<label for="password" class="col-sm-4 col-form-label">Password</label>
		<div class="col-sm-8">
		  <input type="password" class="form-control" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>
		  <small>Password must be 8-20 characters long, contain letters, special characters, numbers and must not contain spaces.</small>
		</div>
	  </div>
	  <div class="form-group row">
		<label for="confirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
		<div class="col-sm-8">
		  <input type="password" class="form-control" name="confirmPassword" value="<?= isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : ''; ?>" required>
		  <?php	if(isset($passwordError)) {?>
			<small class="text-danger"><i class="fa fa-fw fa-exclamation-circle"></i><strong><?php echo $passwordError; ?></strong></small>
		  <?php } ?>
		</div>
	  </div>
	  <div class="form-group row">
		<div class="col-sm text-center">
		  <button type="submit" class="btn btn-primary" name="submit">Register <span class="fa fa-user-plus"></span></button>
		</div>
	  </div>
	</form>
	<p class="text-center">Already registered? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
