<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include ('../koneksi.php');

$total_delivery = $koneksi->query("SELECT COUNT(*) AS total_delivery FROM delivery")->fetch_assoc()['total_delivery'];
$completed_delivery = $koneksi->query("SELECT COUNT(*) AS completed_delivery FROM delivery WHERE status = 'Completed'")->fetch_assoc()['completed_delivery'];
$onProgress_delivery = $koneksi->query("SELECT COUNT(*) AS onProgress_delivery FROM delivery WHERE status != 'Completed'")->fetch_assoc()['onProgress_delivery'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<link rel="icon" href="assets/icon.png" />
	<link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Deliquick Admin</title>
    <link rel="stylesheet" href="../css/admin.css" />
</head>

<body onload="helloToast()">
	<div class="sidebar">
		<div class="logo-details">
            <img src="../assets/logo.png" alt=""/>
			<span class="logo_name">DeliQuick</span>
		</div>
		<ul class="nav-links">
			<li>
				<a href="dashboard.php" class="active">
					<i class='bx bxs-dashboard' ></i>
					<span class="links_name">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="delivery.php">
					<i class='bx bxs-truck'></i>
					<span class="links_name">Deliveries</span>
				</a>
			</li>
			<li>
				<a href="transaction.php">
					<i class='bx bxs-notepad'></i>
					<span class="links_name">Transaction</span>
				</a>
			</li>
			<?php if($_SESSION['role']=='super admin'){ ?>
			<li>
				<a href="user.php">
					<i class='bx bxs-user' ></i>
					<span class="links_name">User</span>
				</a>
			</li>
            <?php } ?>
			<li>
				<a id="logout">
					<i class="bx bx-log-out"></i>
					<span class="links_name">Log out</span>
				</a>
			</li>
		</ul>
	</div>
	<section class="home-section">
		<nav>
			<div class="sidebar-button">
				<i class="bx bx-menu sidebarBtn"></i>
			</div>
			<div class="profile-details" id="profile">
                <i class='bx bxs-user-circle'></i>
				<span class="admin_name"><?= $_SESSION['username'] ?></span>
			</div>
		</nav>
		<div class="card">
        <h2>Dashboard</h2>
		<div style="display: flex;">
			<div class="data-widget">
				<div class="widget-header">
					<h3>Delivery</h3>
				</div>
				<div class="widget-content">
					<h1><?php echo $total_delivery; ?></h1>
					<p>Total Delivery in the database</p>
				</div>
			</div>
			<div class="data-widget">
				<div class="widget-header">
					<h3>Completed Delivery</h3>
				</div>
				<div class="widget-content">
					<h1><?php echo $completed_delivery; ?></h1>
					<p>Completed Delivery in the database</p>
				</div>
			</div>
			<div class="data-widget">
				<div class="widget-header">
					<h3>On Progress Delivery</h3>
				</div>
				<div class="widget-content">
					<h1><?php echo $onProgress_delivery; ?></h1>
					<p>Still On Progress delivery in the database</p>
				</div>
			</div>
			</div>
		</div>
        
	</section>
	<!-- toast -->
	<div id="snackbar">Selamat Datang <?= $_SESSION['username'] ?></div>
	<!-- logout modal -->
	<div id="logoutModal" class="modal">
		<div class="modal-content">
			<p>Are you sure you want to log out?</p>
			<button id="confirmLogout" class="btn btn-primary">Yes</button>
			<button id="cancelLogout" class="btn btn-secondary">No</button>
		</div>
	</div>
	<!-- profile modal -->
	<div id="profileModal" class="modal">
		<div class="modal-content form-profile">
		  <h2>My profile</h2>
            <form action="index.html">
            <input class="input" type="text" name="username" placeholder="<?= $_SESSION['username'] ?>" readonly/>
            <input class="input" type="text" name="email" placeholder="<?= $_SESSION['email'] ?>"/>
            <button type="button" class="btn btn-secondary" id="closeProfileModal">Close</button>
            </form>
		</div>
	</div>

	<script>
	//toast
	function helloToast() {
		var x = document.getElementById("snackbar");
		x.className = "show";
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	}

	//logout modal
	document.getElementById("logout").addEventListener("click", showModal);
	document.getElementById("confirmLogout").addEventListener("click", confirmLogout);
	document.getElementById("cancelLogout").addEventListener("click", hideModal);

	const modal = document.getElementById("logoutModal");

	function showModal() {
		document.getElementById("logoutModal").style.display = "block";
	}

	function confirmLogout() {
		window.location.href = "../logout.php";
	}

	function hideModal() {
		document.getElementById("logoutModal").style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == document.getElementById("logoutModal")) {
			document.getElementById("logoutModal").style.display = "none";
		}
		if (event.target == document.getElementById("profileModal")) {
			document.getElementById("profileModal").style.display = "none";
		}
	}

	//profile modal
	document.getElementById("profile").addEventListener("click", showProfileModal);
	document.getElementById("closeProfileModal").addEventListener("click", hideProfileModal);

	function showProfileModal() {
		document.getElementById("profileModal").style.display = "block";
	}

	function hideProfileModal() {
		document.getElementById("profileModal").style.display = "none";
	}


	</script>
</body>

</html>
