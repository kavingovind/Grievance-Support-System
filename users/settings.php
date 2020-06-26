
<?php
	session_start();
	
	include('../dbconnect.php');
	
	if (!isset($_SESSION['username']))
	{
		header('location: login.php');
	}
	$username = $_SESSION['username'];
	$query = "SELECT * FROM `complaints` WHERE status=0;";
	$results = mysqli_query($db, $query);
	$count = mysqli_num_rows($results);
	
	$query = "SELECT * FROM `users` WHERE username='$username'";
	$results = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($results);
	
	// Update Profile
	if (isset($_POST['submit'])) 
	{
		$fullname = mysqli_real_escape_string($db, $_POST['fullname']);
		$email = mysqli_real_escape_string($db, $_POST['email']);		
		$update = "UPDATE users SET fullname='$fullname', email='$email' WHERE username='$username'";
		mysqli_query($db, $update);
		$messageSuccess = "Your profile updated successfully";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile Settings</title>
  <!--BootStrap-->
  <!--BootStrap-->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <!--JavaScript-->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <style>
	.nav-item{
		padding: 0px 10px; 
	}
    .hr{
		width: 95px;
		height: 1px;
		background-color: #00d1b5;
	}
	.content{
	  margin-top: 2%;
	  max-width: 900px;
	}
    .row{
      padding: 10px;
    }
  </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <div class="container">
	    <!-- Just an image -->
	    <div class="navbar-brand">
		  <img src="../images/user.png" width="30" height="30" alt="">
	    </div>
	    <!-- Menu Icon -->
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"                         aria-label="Toggle navigation">
  		  <span class="navbar-toggler-icon"></span>
	    </button>
  	    <!-- Nav Links -->
	    <div class="collapse navbar-collapse justify-content-md-center" id="navbarSupportedContent">
		  <ul class="navbar-nav mr-auto">
		    <li class="nav-item">
			  <a class="nav-link text-white" href="index.php">Home</a>
		    </li>
			<li class="nav-item">
			  <a class="nav-link text-white" href="complaints.php">Complaints Pending <?php if($count>0) { ?> <span class="bg-warning" style="padding: 4px 10px; border-radius: 50%;"><?php echo $count; ?></span><?php } ?></a>
		    </li>
			<li class="nav-item">
			  <a class="nav-link text-white" href="complaints-cleared.php">Complaints Cleared</a>
		    </li>
			<li class="nav-item">
			  <a class="nav-link text-white" href="settings.php">Profile Settings</a>
		    </li>
		  </ul>
		  <!-- Logout Button-->
		  <div class="nav-item">
			<button class="btn btn-dark" data-toggle="modal" data-target="#logoutModal">
			  <i class="fa fa-fw fa-sign-out"></i>Logout
			</button>
		  </div>
	    </div>
	  </div>
    </nav>
	
	<!-- Body Section -->
	<div class="container-fluid">
		<div class="container content shadow-sm p-3 mb-5 bg-white rounded">
			<div class="text-dark text-center alert">
			  <h5>Update Profile</h5>
			  <hr class="hr">
			</div>
			<?php if(isset($messageSuccess))
			{?>
			  <div class="alert alert-success alert-dismissible fade show" role="alert">
				<i class="fa fa-fw fa-check-circle"></i><?php echo $messageSuccess; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			<?php } ?>
			<form action="" method="POST">
			  <div class="form-group row">
				<label for="username" class="col-sm-3 col-form-label">Username</label>
				<div class="col-sm-9">
				  <input type="text" id="username" class="form-control" name="username" value="<?php echo "$row[username]" ?>" disabled required>
				  <small>*Username cannot be changed</small>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="fullname" class="col-sm-3 col-form-label">Name</label>
				<div class="col-sm-9">
				  <input type="text" id="fullname" class="form-control" name="fullname" value="<?= isset($_POST['fullname']) ? $_POST['fullname'] : "$row[fullname]"; ?>" required>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="email" class="col-sm-3 col-form-label">Email</label>
				<div class="col-sm-9">
				  <input type="email" class="form-control" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : "$row[email]"; ?>" required>
				</div>
			  </div>
			  <div class="form-group row text-center">
				<div class="col-sm-10">
				  <button type="submit" class="btn btn-success" name="submit">Update</button>
				</div>
			  </div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="logoutModalLabel">Logout</h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
		  </div>
		  <div class="modal-body">Are you sure you want to logout?</div>
		  <div class="modal-footer">
			<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
			<a class="btn btn-primary" href="logout.php">Logout</a>
		  </div>
		</div>
	  </div>
	</div>
</body>
</html>