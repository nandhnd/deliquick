<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include ('../koneksi.php');

$receipt_id=$_GET['receipt'];
$sql = "SELECT receipt_id, status, date, time, location FROM shipping WHERE receipt_id = '$receipt_id' ORDER BY id DESC";
$result = $koneksi->query($sql);
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

<body>
	<div class="sidebar">
		<div class="logo-details">
            <img src="../assets/logo.png" alt=""/>
			<span class="logo_name">DeliQuick</span>
		</div>
		<ul class="nav-links">
			<li>
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="links_name">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="delivery.php"  class="active">
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
        <h2><a href="delivery.php" style="text-decoration: none;">Deliveries</a>>Shipping</h2><br>
        <h3><?= $_GET['receipt'] ?></h3>
        <button class="btn btn-add" style="margin-top: 15px;" onclick="openModal()">Add Shipping Status</button>
        <table>
            <thead>
            <tr>
                <th>Status</th>
                <th>Location</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>" . $row['location'] . "</td>";
							echo "<td>" . $row['date'] ." ". $row['time'] . "</td>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No users found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
        
        <!-- add Shipping Modal -->
        <div class="modal" id="addModal">
            <div class="modal-content-form">
                <h2>Add Shipping Status</h2>
                <form method="post" action="shipping-add.php">
                    <div class="form-group">
                        <input type="text" id="receipt_id" name="receipt_id" value="<?=$_GET['receipt']?>" hidden readonly required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="Menunggu pickup">Menunggu pickup</option>
                            <option value="Menuju kantor cabang">Menuju kantor cabang</option>
                            <option value="Tiba di kantor cabang">Tiba di kantor cabang</option>
                            <option value="Diantar ke penerima">Diantar ke penerima</option>
                            <option value="Tiba di tujuan">Tiba di tujuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary" name="add" id="add">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editModal" class="modal">
            <div class="modal-content-form">
                <h2>Edit User</h2>
                <form id="editForm" method="post" action="user-update.php">
                    <input type="hidden" name="id" id="edit_user_id">
                    <label for="edit_username">Username:</label>
                    <input type="text" id="edit_username" name="username" required>
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="email" required>
                    <label for="edit_role">Role:</label>
                    <select id="edit_role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="super admin">Super Admin</option>
                    </select>
                    <div class="button-group">
                        <button type="submit" name="edit" id="edit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" onclick="closeEditModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
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
            // Open the modal
            function openModal() {
                document.getElementById("addModal").style.display = "block";
            }

            // Close the modal
            function closeModal() {
                document.getElementById("addModal").style.display = "none";
            }

            // Close modal if user clicks outside
            window.onclick = function(event) {
                if (event.target === document.getElementById("editModal")) {
                    closeModal();
                }
            }

            function openEditModal(userData) {
                document.getElementById('edit_user_id').value = userData.id;
                document.getElementById('edit_username').value = userData.name;
                document.getElementById('edit_email').value = userData.email;
                document.getElementById('edit_role').value = userData.role;

                // Show the modal
                document.getElementById('editModal').style.display = 'block';
            }

            function closeEditModal() {
                document.getElementById('editModal').style.display = 'none';
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
	</section>
</body>


</html>
