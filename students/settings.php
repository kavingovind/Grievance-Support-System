
<?php
	session_start();
	
	include('../dbconnect.php');
	
	if (!isset($_SESSION['username']))
	{
		header('location: login.php');
	}
	$username = $_SESSION['username'];
	$query = "SELECT * FROM `students` WHERE username='$username'";
	$results = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($results);
	
	// Update
	if (isset($_POST['submit'])) 
	{
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$fullname = mysqli_real_escape_string($db, $_POST['fullname']);
		$yearOfStudying = mysqli_real_escape_string($db, $_POST['yearOfStudying']);
		$department = mysqli_real_escape_string($db, $_POST['department']);
		$college = mysqli_real_escape_string($db, $_POST['college']);
		$university = mysqli_real_escape_string($db, $_POST['university']);
		
		$update = "UPDATE students SET email='$email', fullname='$fullname', university='$university', college='$college', department='$department', year='$yearOfStudying' WHERE username='$username'";
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
  			  <a class="nav-link text-white" href="new-complaint.php">New Complaint</a>
		    </li>
		    <li class="nav-item">
			  <a class="nav-link text-white" href="my-complaints.php">My Complaints</a>
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
			  <div class="form-group row">
				<label for="yearOfStudying" class="col-sm-3 col-form-label">Year of Studying</label>
				<div class="col-sm-9">
				  <input type="number" class="form-control" name="yearOfStudying" min="1" max="5" value="<?= isset($_POST['year']) ? $_POST['year'] : "$row[year]"; ?>" required>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="department" class="col-sm-3 col-form-label">Department</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" name="department" value="<?= isset($_POST['department']) ? $_POST['department'] : "$row[department]"; ?>" required>
				  <small>For Eg: B.A Zoology, B.Tech Information Technology etc</small>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="college" class="col-sm-3 col-form-label">College</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" name="college" value="<?= isset($_POST['college']) ? $_POST['college'] : "$row[college]"; ?>" required>
				  <small>For Eg: PSG College of Technology</small>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="university" class="col-sm-3 col-form-label">University</label>
				<div class="input-group mb-3 col-sm-9">
				  <select id="university" name="university" class="custom-select" required>
					<option value="<?= isset($_POST['university']) ? $_POST['university'] : "$row[university]"; ?>" selected><?php echo "$row[university]"?></option>
					<option value="Anna University">Anna University</option>
					<option value="Annamalai University">Annamalai University</option>
					<option value="Bharathiyar University">Bharathiyar University</option>
					<option value="MGR University">MGR University</option>
					<option value="TN Agricultural University">TN Agricultural University</option>
				  </select>
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