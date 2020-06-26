
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
	
	// Post Complaints
	if (isset($_POST['submit'])) 
	{
		if(!empty($_POST['category']) && !empty($_POST['description']))
		{
			$category = mysqli_real_escape_string($db, $_POST['category']);
			$description = mysqli_real_escape_string($db, $_POST['description']);
			$query = "INSERT INTO complaints (username, university, college, department, year, category, description, status) VALUES('$username', '$row[university]',
			'$row[college]', '$row[department]', '$row[year]', '$category', '$description', 0)";
			mysqli_query($db, $query);
			$messageSuccess = "Your grievance has been registered.";
		}
		else
		{
			$messageError = "Enter all the fields";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>New Complaint</title>
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
			  <h5>Post New Complaint</h5>
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
			<?php if(isset($messageError))
			{?>
			  <div class="alert alert-warning alert-dismissible fade show" role="alert">
				<i class="fa fa-fw fa-exclamation-circle"></i><?php echo $messageError; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			<?php } ?>			
			<form action="" method="POST">
			  <div class="form-group row">
				<label for="category" class="col-sm-2 col-form-label">Category</label>
				<div class="input-group mb-3 col-sm-10">
				  <select id="category" name="category" class="custom-select" required>
					<option disabled selected>--Select--</option>
					<option value="Administration">Administration</option>
					<option value="Examination">Examination</option>
					<option value="Fees">Fees</option>
					<option value="Paper Valuation">Paper Valuation</option>
					<option value="Teaching">Teaching</option>
					<option value="Other">Other</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="description" class="col-sm-2 col-form-label">Complaint Description</label>
				<div class="col-sm-10">
				  <textarea type="text" class="form-control" name="description" rows="4" minlength="20" required></textarea>
				</div>
			  </div>
			  <div class="form-group row text-center">
				<div class="col">
				  <button type="submit" class="btn btn-success" name="submit"> Submit </button>
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