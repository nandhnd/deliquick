<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link rel="icon" href="assets/icon.png" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
	href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@500;700&display=swap"
			rel="stylesheet"
		/>
  <link
	rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <div class="container">
	<main>
	  <div class="center">
	    <div class="form-login">
            <div class="logo">
                <img src="assets/logo.png" alt=""/>
            </div>
            <h3>Login</h3>
            <?php if (isset($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
            <form method="post" action="login-proses.php">
            <input class="input" type="text" name="email" placeholder="Email" required/>
            <input class="input" type="password" name="password" placeholder="Password" required/>
            <button type="submit" class="btn_login" name="login" id="login">Login</button>
            </form>
            <a href="register.php" class="link-register">Register</a>
      </div>
	  </div>
	</main>
   </div>
</body>
</html>
