<?php
	$Db = Connect();
	
	function Connect() {
		$Host = "localhost";
		$User = "root";
		$Pass = "";
		$Name = "calendardb";
		
		return mysqli_connect($Host, $User, $Pass, $Name);
	}

	function displayDate() {
		echo "week" . date(" W, F Y");
	}
	
	function displayTable() {
		for ($Hour = 8; $Hour <= 20; $Hour++) {
			echo "<tr>";
			if (isset($_GET["Year"])) $Year = $_GET["Year"]; else $Year = date("Y");
			if (isset($_GET["Week"])) $Week = $_GET["Week"]; else $Week = date("W");			
			
			echo "<td>" . sprintf("%02d", $Hour) . ":00" . "</td>";
			
			for ($Day = 0; $Day < 7; $Day++) {
				echo "<td>";
				if (isReserved($Year, $Week, $Day, $Hour)) echo '<div class="dot"></div>';
				echo "</td>";
			}	
			
			echo "</tr>";
		}
	}
	
	function isReserved($Year, $Week, $Day, $Hour) {
		global $Db;
		$sqlQuery = "SELECT * FROM reservations WHERE Year=$Year AND Week=$Week AND Day=$Day AND Hour=$Hour";
		$Query = mysqli_query($Db, $sqlQuery);
		$RowsCount = mysqli_num_rows($Query);
		return $RowsCount > 0;
	}
	
	function reservate($Year, $Week, $Day, $Hour) {
		global $Db;
		$sqlQuery = "INSERT INTO reservations VALUES (NULL, $Year, $Week, $Day, $Hour)";
		$Query = mysqli_query($Db, $sqlQuery);
	}
?>
