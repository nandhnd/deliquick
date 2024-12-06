<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include ('../koneksi.php');

$sql = "SELECT * FROM transaction ORDER BY receipt_id DESC";
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
				<a href="transaction.php"  class="active">
					<i class='bx bxs-notepad'></i>
					<span class="links_name">Transaction</span>
				</a>
			</li>
			<li>
				<a href="user.php">
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
			<div class="profile-details" id="profile">
                <i class='bx bxs-user-circle'></i>
				<span class="admin_name"><?= $_SESSION['username'] ?></span>
			</div>
		</nav>
        <div class="card">
        <h2>Transaction</h2>
        <a href="transaction-cetak.php"><button class="btn btn-edit" style="margin-top: 15px;">Print PDF</button></a>
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Receipt ID</th>
                <th>Date</th>
                <th>Payment Method</th>
				<th>Amount</th>
				<th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td><a href='shipping.php?receipt=". $row['receipt_id'] ."'>" . $row['receipt_id'] . "</a></td>";
                            echo "<td>" . substr($row['date'], 0, 10) . "</td>";
                            echo "<td>" . $row['payment_method'] . "</td>";
							echo "<td>" . $row['amount'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-edit' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
        
        <!-- add Delivery Modal -->
        <div class="modal" id="editModal">
            <div class="modal-content-form">
                <h2>Edit Transaction</h2>
                <form method="post" action="transaction-update.php">
                    <div class="form-group">
                        <label for="receipt_id">Receipt ID</label>
                        <input type="text" id="receipt_id" name="receipt_id"  readonly required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" id="date" name="date" readonly required>
                    </div>
					<div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method">
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
					<div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="Waiting Payment">Waiting Payment</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary" name="edit" id="edit">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
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
                <input class="input" type="text" name="phone" placeholder="081123321123"/>
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

            function openEditModal(transactionData) {
                document.getElementById('receipt_id').value = transactionData.receipt_id;
                document.getElementById('date').value = transactionData.date.substr(0,10);
                document.getElementById('payment_method').value = transactionData.payment_method;
                document.getElementById('amount').value = transactionData.amount;
                document.getElementById('status').value = transactionData.status;
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
