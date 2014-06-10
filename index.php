<?php include_once "views/header.php" ?>

	<h2>Welcome!</h2>

	<!-- Initial registration form, get some user information. -->
	<p>Please introduce yourself.</p>
	<form id="registerForm" class="form-design" onsubmit="return false">
		<p>Enter your name.</p>
		<input id="name" type="text" placeholder="Name">
		<div class="error" id="nameErr">Your name cannot be blank.</div>

		<p>Enter your age.</p>
		<input id="age" type="number" maxlength="2" placeholder="Age">
		<div class="error" id="ageErr">Your age is invalid.</div>

		<p>What is your primary job or occupation?</p>
		<input id="job" type="text" placeholder="Job">
		<div class="error" id="jobErr">You have to have some sort of job.</div>

		<br><br>
		<button id="submit" onclick="register()">Sign Up</button>
	</form>
	<div id="submitMsg"></div>


<?php include_once "views/footer.php" ?>

	<script type="text/javascript">

	function register() {

		// Boolean used for err checking
		var goodInput = true;

		var usersName = $("name").value;
		var usersAge = $("age").value;
		var usersJob = $("job").value;

		// Error testing and showing/hiding error messages
		if (usersName == "") {
			$("nameErr").style.display = 'block';
			goodInput = false;
		}
		else {
			$("nameErr").style.display = 'none';
		}
		if (usersAge < 1 || usersAge > 99) {
			$("ageErr").style.display = 'block';
			goodInput = false;
		}
		else {
			$("ageErr").style.display = 'none';
		}
		if (usersJob == "") {
			$("jobErr").style.display = 'block';
			goodInput = false;
		}
		else {
			$("jobErr").style.display = 'none';
		}

		// Hooray, no errors, so save the users inforation 
		if (goodInput) {

			// Save in object to demonstrate knowledge of objects and for future expansion
			var user = {
				name: usersName,
				age: usersName,
				job: usersJob
			};

			window.name = user.name;
			window.age = user.age;
			window.job = user.job;

			$("submitMsg").innerHTML = "Information submitted successfully.";

		}
		else {
			$("submitMsg").innerHTML = "Information not submitted.";
		}

	}

	</script>