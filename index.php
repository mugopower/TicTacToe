<?php

require_once('class/class.tictac.php');
session_start();

if (!isset($_SESSION['game']['tictac']))
	$_SESSION['game']['tictac'] = new tictac(); //Instantiate class game 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Eezipay Quick Tick Tack Toe Game</title>
		<link rel="stylesheet" type="text/css" href="assets/style.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Eezipay Quick Tick Tack Toe Test">
		<meta name="keywords" content="PHP, Tic Tac Toe, HTML, CSS">
		<meta name="author" content="MugoTech">
	</head>

	<body>
		<div id="content">
			<form name ="tictac" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<h1>Multiplayer Tic Tac Toe Game</h1>
				<?php
					$_SESSION['game']['tictac']->play($_POST);
				?>
			</form>
		</div>
	</body>
</html>