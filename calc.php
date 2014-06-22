<?php include_once "views/header.php"; ?>
		<h2> Calculator </h2>

		<h3>
		<!-- Simple hello message. -->
		Hello there, 
		<script> 
			if (window.name == "")
				document.write("Anonymous");
			else
			document.write(window.name); 
		</script>! 
		</h3>

		<!-- Information used for calculaor -->
		<form id="form" class="form-design" onsubmit="return false">
			<h4>Please answer the following questions.</h4>
			<p>How much do you make per pay period?</p>
			<input id="income" name="income" type="number" value="100" placeholder="Amount">
			<p>How often are you paid?</p>
			<div id="payperiod">
				<input name="pay" id="pay1" type="radio" value="week">Weekly
				<input name="pay" id="pay2" type="radio" value="biweek">Bi-Weekly
				<input name="pay" id="pay3" type="radio" value="month">Monthly
			</div>
			<p>What percentage would you like to spend?</p>
			<input id="percentsave" name="percentsave" maxlength="3" type="number" value="25" placeholder="Percentage"><br><br>
			<button id="submit" onclick="confirmValues()">Generate</button>
		</form>

		<!-- Table to display information -->
		<table id="table" style="display: none;">
			<thead>
				<tr>
					<th>Time Saved</th>
					<th>Can Spend ($)</th>
					<th>Item</th>
					<th>Price ($)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>One Week</td>
					<td><div id="weekAmt"></div></td>
					<td><div id="weekItem"></div></td>
					<td><div id="weekItemPr"></div></td>
				</tr>
				<tr>
					<td>One Month</td>
					<td><div id="monthAmt"></div></td>
					<td><div id="monthItem"></div></td>
					<td><div id="monthItemPr"></div></td>
				</tr>
				<tr>
					<td>One Year</td>
					<td><div id="yearAmt"></div></td>
					<td><div id="yearItem"></div></td>
					<td><div id="yearItemPr"></div></td>
				</tr>
			</tbody>
		</table>

	</div>

	<script type="text/javascript">

	//$("info").submit(function() { return false; });

		function calculate(weekSalary, percentage) {
			
			// Unhide table now that we have info to show.
			$("table").style.display = '';

			// Calc. what the user can spend per week. Rounded so there are not 9 zillion decimals
			canSpendWeekly = Math.round((weekSalary * percentage)*100) / 100;

			month = 4;
			year = 52.1775;

			// getItems();
			// Return users items in a 2d array
			// var items[][] = getItems();

			// Get the items and show them along with what user can spend

			$("weekAmt").innerHTML = canSpendWeekly;
			getItems(canSpendWeekly);
			$("weekItem").innerHTML = document.item;
			$("weekItemPr").innerHTML = document.itemPrice;

			$("monthAmt").innerHTML = canSpendWeekly * month;
			getItems(canSpendWeekly * month);
			$("monthItem").innerHTML = document.item;
			$("monthItemPr").innerHTML = document.itemPrice;

			$("yearAmt").innerHTML = canSpendWeekly * year;
			getItems(canSpendWeekly * year);
			$("yearItem").innerHTML = document.item;
			$("yearItemPr").innerHTML = document.itemPrice;

		}

		function confirmValues() {

			var errors = false;
			// No matter what pay period the user chooses, we will break it down by week.
			var weekSalary; 
			var salary = $("income").value;
			salary = parseInt(salary);

			// Confirm salary is a number above 0.
			if (isNaN(salary) || salary < 0) {
				alert("Not a valid salary");
				errors = true;
			}

			// alert(salary);
			period = getPayPeriod();

			if (period == -1) {
				alert("You have to select a pay period");
				errors = true;
			}
			else {
				weekSalary = salary / period;
			}

			var percentage = $("percentsave").value;
			percentage = parseInt(percentage);

			if (isNaN(percentage) || percentage < 0 || percentage > 100) {
				alert("Invalid percentage specified.");
				errors = true;
			}
			else {
				percentage = percentage / 100; // Put in form useful for math.
			}


			// No errors on input, lets calculate 
			if (!errors) {
				calculate(weekSalary, percentage); 
			}

		}

		function getPayPeriod() {

			// Period will be what we divide the salary by to get one weeks pay.

			if ($("pay1").checked) {
				period = 1;
			}
			else if ($("pay2").checked) {
				period = 2;
			}
			else if ($("pay3").checked) {
				period = 4; // 4 weeks in a month.
			}
			else {
				period = -1;
			}

			return period;
		}

		function getItems(canSpendAmount) {


			/* Define some price ranges */

			//Above 0
			var tier0 = [
				["Fresh Air", "0"],
				["Sunlight", "0"]
			];


			//Under 10
			var tier1 = [
				["Pack of Gum", "2"],
				["Venus Flytrap", "8"],
				["1lb Apples", "3"]
			];

			//Under 20
			var tier2 = [
				["RC Helicopter", "18"],
				["1500 Lady Bugs", "15"],
				["Rubix Cube", "14"]
			];

			//Under 50
			var tier3 = [
				["Stainless Steel Bowl Set", "29"],
				["Google Chromecast", "35"]
			];

			//Under 100
			var tier4 = [
				["Amazon Fire TV", "99"],
				["Roku 3", "85"],
				["Kindle", "69"]
			];

			//Under 200
			var tier5 = [
				["Kindle Paperwhite", "119"],
				["Canon PowerShot SX170", "149"]
			];

			//Under 500
			var tier6 = [
				["Apple iPad", "400"],
				["Xbox One", "399"],
				["PS4", "399"]
			];

			// Self note: Eventually, all products will be in a database or pulled it from Amazon api. If products in database, place in random order and go through until one fits price range (close to). Let people like or dislike choices.

			if (canSpendAmount > 500)
				tier = tier6;
			else if (canSpendAmount > 200)
				tier = tier5;
			else if (canSpendAmount > 100)
				tier = tier4;
			else if (canSpendAmount > 50)
				tier = tier3;
			else if (canSpendAmount > 20)
				tier = tier2;
			else if (canSpendAmount > 10)
				tier = tier1;
			else
				tier = tier0;

			/*
			if (canSpendAmount < 10)
				tier = tier1;
			else if (canSpendAmount < 20)
				tier = tier2;
			else if (canSpendAmount < 50)
				tier = tier3;
			else if (canSpendAmount < 100)
				tier = tier4;
			else if (canSpendAmount < 200)
				tier = tier5;
			else
				tier = tier6;
			*/

			//What tier we are getting
			//tier = "tier" + tier;

			// alert(tier+" "+tier[0].length);

			// Fix this part
			itemNum  = Math.floor(Math.random() * tier.length);

			document.item = tier[itemNum][0];
			document.itemPrice = tier[itemNum][1];

			// alert(itemNum);

		}

		// document.main = $("mainBtn");


		function display() {

			//if (window.main =)

		}



	</script>

<?php include_once "views/footer.php"; ?>