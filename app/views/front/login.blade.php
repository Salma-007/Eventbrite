<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Login Page </title>
	<link rel="stylesheet" href="/assets/css/login-Style.css">
</head>
<body>
	<section>
		<div class="leaves">
			<div class="set">
				<div><img src="/assets/img/login-register/leaf_01.png"></div>
				<div><img src="/assets/img/login-register/leaf_02.png"></div>
				<div><img src="/assets/img/login-register/leaf_03.png"></div>
				<div><img src="/assets/img/login-register/leaf_04.png"></div>
				<div><img src="/assets/img/login-register/leaf_01.png"></div>
				<div><img src="/assets/img/login-register/leaf_02.png"></div>
				<div><img src="/assets/img/login-register/leaf_03.png"></div>
				<div><img src="/assets/img/login-register/leaf_04.png"></div>
			</div>
		</div>
		<img src="/assets/img/login-register/bg.jpg" class="bg">
		<img src="/assets/img/login-register/girl.png" class="girl">
		<img src="/assets/img/login-register/trees.png" class="trees">
		<div class="login">
			<h2>Sign In</h2>
			<?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
        <form action="/login"  method="POST">
			<div class="inputBox">
				<input type="text" name="email" placeholder="Email">
			</div>
			<div class="inputBox">
				<input type="password" name="password" placeholder="Password">
			</div>
			<div class="inputBox">
				<input type="submit" value="Login" id="btn">
			</div>
			<div class="group">
				<a href="#">Forget Password</a>
				<a href="/signup">Signup</a>
			</div>
         </form>
		</div>
		
	</section>
</body>
</html>