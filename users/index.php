
<?php
	session_start();
	
	include('../dbconnect.php');
	
	if (!isset($_SESSION['username']))
	{
		header('location: login.php');
	}
	$query = "SELECT * FROM `complaints` WHERE status=0;";
	$results = mysqli_query($db, $query);
	$count = mysqli_num_rows($results);
	
	$query = "SELECT COUNT(*) FROM `complaints`";
	$result = mysqli_query($db, $query);
	$totalCompliants = mysqli_fetch_assoc($result);
	
	$query = "SELECT COUNT(*) FROM `complaints` WHERE status=0;";
	$result = mysqli_query($db, $query);
	$pendingCompliants = mysqli_fetch_assoc($result);
	
	$query = "SELECT COUNT(*) FROM `complaints` WHERE status=1";
	$result = mysqli_query($db, $query);
	$clearedCompliants = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
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
		width: 50px;
		height: 1px;
		background-color: #00d1b5;
	}
	.content{
	  margin-top: 5%;
	  max-width: 920px;
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
			<div class="text-center"><h5>Dashboard</h5></div>
			<hr class="hr">
			<div class="row">
				<div class="card text-white bg-primary mb-3" style="min-width: 18rem; margin: 5px;">
				  <div class="card-body">
					<h5 class="card-title">Total Complaints</h5>
					<p class="card-text"><h1 class="float-right"><?php echo implode($totalCompliants); ?></h1></p>
				  </div>
				</div>
				<div class="card text-white bg-warning mb-3" style="min-width: 18rem; margin: 5px;">
				  <div class="card-body">
					<h5 class="card-title">Complaints Pending</h5>
					<p class="card-text"><h1 class="float-right"><?php echo implode($pendingCompliants); ?></h1></p>
				  </div>
				</div>
				<div class="card text-white bg-success mb-3" style="min-width: 18rem; margin: 5px;">
				  <div class="card-body">
					<h5 class="card-title">Complaints Processed</h5>
					<p class="card-text"><h1 class="float-right"><?php echo implode($clearedCompliants); ?></h1></p>
				  </div>
				</div>
			</div>
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