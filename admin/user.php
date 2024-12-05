<?php
include ('../koneksi.php');

$sql = "SELECT id, name, email, role FROM user";
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
				<a href="delivery.php">
					<i class='bx bxs-truck'></i>
					<span class="links_name">Deliveries</span>
				</a>
			</li>
			<li>
				<a href="user.php" class="active">
					<i class='bx bxs-user' ></i>
					<span class="links_name">User</span>
				</a>
			</li>
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
			<div class="profile-details">
                <i class='bx bxs-user-circle'></i>
				<span class="admin_name">Admin</span>
			</div>
		</nav>
        <div class="card">
        <h2>User Data</h2>
        <button class="btn btn-add" style="margin-top: 15px;" onclick="openModal()">Add User</button>
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['role'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-edit' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button>
                                </td>";
                            echo "<td>
                                    <a href='user-delete.php/?id=". $row['id'] . "'><button class='btn btn-delete'>Delete</button></a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No users found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
        
        <!-- add User Modal -->
        <div class="modal" id="addModal">
            <div class="modal-content-form">
                <h2>Add User</h2>
                <form method="post" action="user-add.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role">   
                            <option value="admin">Admin</option>
                            <option value="super admin">Super Admin</option> 
                        </select>                    
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
        </script>
	</section>
</body>


</html>
