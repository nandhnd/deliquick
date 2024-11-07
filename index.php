<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <title>deliquick</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
		<header>
			<nav>
				<div class="logo">
					<img src="assets/logo.png" alt=""/>
				</div>
				<input type="checkbox" id="click" />
				<label for="click" class="menu-btn">
					<i class="fas fa-bars"></i>
				</label>
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="categories/categories.html">Services</a></li>
                    <li><a href="categories/categories.html">Search</a></li>
                    <li><a href="categories/categories.html">Contact Us</a></li>
                    <li><a href="categories/categories.html">FAQ</a></li>
                    <li><a href="login.html" class="btn_login">User</a></li>
				</ul>
			</nav>
		</header>
        <main>
			<div class="jumbotron">
                <div class="jumbotron-img">
					<img src="assets/deliveryman.jpg" alt="" />
				</div>
				<div class="jumbotron-text">
					<h1>QUICK DELIVERY </h1><h1>WITH </h1><h1 class="green">DELIQUICK</h1>
				</div>
			</div>
			<div class="searchbar">
                <div class="track">
                    <div class="label">Tracking</div>
                    <input type="text">
                </div>
                <div class="track">
                    <div class="label">Delivery Fee Check</div>
                    <input type="text" onfocus="displayFeeBox()" onfocusout="hideFeeBox()">
                </div>
            </div>
			<div class="main-banner" id="fee-box" style="display: none;">
				<div class="box-fee">
					<form action="">
						<div class="form">
							<i class='bx bx-map'></i>
							<input type="text" placeholder="Kota Awal" autocomplete="off" params="1" required="" onfocus="displayFeeBox()">
							<input type="hidden" name="origin">
							<div class="autocomplete-box"></div>
						</div>
						<div class="field field-to field-autocomplete">
							<i class='bx bxs-map-pin' ></i>
							<input type="text" placeholder="Kota Tujuan" autocomplete="off" params="2" required="">
							<input type="hidden" name="destination">
							<div class="autocomplete-box"></div>
						</div>
						<div class="field field-weight">
							<i class='bx bx-cube'></i>
							<input type="text" placeholder="Berat barang" name="weight" required="">
							<span class="weight">kg</span>
						</div>
						<div class="btn">
							<button href="https://www.jne.co.id/shipping-fee" class="button button-outline btn-hitung" type="submit">Check</button>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
    <footer>
        <h4>&copy; deliquick 2024</h4>
    </footer>
	<script>
		function displayFeeBox() {
			document.getElementById("fee-box").style.display = "block";
		}
		function hideFeeBox() {
			document.getElementById("fee-box").style.display = "none";
		}
	</script>
</body>
</html>