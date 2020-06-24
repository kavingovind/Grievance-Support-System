
<?php
	session_start();
  
	include('../dbconnect.php');
  
	// Login
	if (isset($_POST['submit'])) 
	{
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = md5(mysqli_real_escape_string($db, $_POST['password']));
		
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);
		$row = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1)
		{
			$_SESSION['username'] = $username;
			header('location: index.php');
		}
		else
		{
			$loginError = "Invalid Username/Password";
		}
	}

?>

<!------------------------------------------------------------>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
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
		margin-top: 5%;
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
  <div class="container shadow p-4 mb-4 bg-white rounded">
	<div class="text-dark text-center alert">
	  <h5>Login</h5>
	  <hr class="hr">
	</div>
	<form action="" method="POST">
	  <div class="form-group row">
		<label for="username" class="col-sm-4 col-form-label">Username</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
		</div>
	  </div>
	  <div class="form-group row">
		<label for="password" class="col-sm-4 col-form-label">Password</label>
		<div class="col-sm-8">
		  <input type="password" class="form-control" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>
		  <?php	if(isset($loginError)) {?>
			<small class="text-danger"><i class="fa fa-fw fa-exclamation-circle"></i><strong><?php echo $loginError; ?></strong></small>
		  <?php } ?>
		</div>
	  </div>
	  <div class="form-group row">
		<div class="col-sm text-center">
		  <button type="submit" class="btn btn-primary" name="submit">Login <span class="fa fa-sign-in"></span></button>
		</div>
	  </div>
	</form>
  </div>
</body>
</html>
