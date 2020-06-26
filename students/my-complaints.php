
<?php
	session_start();
	
	include('../dbconnect.php');
	
	if (!isset($_SESSION['username']))
	{
		header('location: login.php');
	}
	$username = $_SESSION['username'];
	$query = "SELECT * FROM `complaints` WHERE username='$username'";
	$results = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Complaints</title>
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
		    <h5>My Complaints</h5>
		    <hr class="hr">
		  </div>
		  <!-- Complaints Table -->
		  <div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Univeristy</th>
				  <th>College</th>
				  <th>Department</th>
				  <th>Year</th>
				  <th>Category</th>
				  <th>Description</th>
				  <th>Status</th>
				</tr>
			  </thead>
			  <tbody>
				<?php while($row=mysqli_fetch_array($results)):?>
				  <tr>
					<td><?php echo $row['university'];?></td>
					<td><?php echo $row['college'];?></td>
					<td><?php echo $row['department'];?></td>
					<td><?php echo $row['year'];?></td>
					<td><?php echo $row['category'];?></td>
					<td><?php echo $row['description'];?></td>
					<?php if(($row['status'])==1)
					{?>
					  <td><span class="text-success">Processed</span></td>
					<?php } ?>
					<?php if(($row['status'])==0)
					{?>
					  <td><span class="text-info">Pending..<span></td>
					<?php } ?>
				  </tr>
				<?php endwhile;?>
			  </tbody>
			</table>
		  </div>
		  <div class="small text-muted">Last Updated at <script>document.write(new Date());</script></div>
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