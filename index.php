<?php
	session_start();
?>

<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
-->
<head>
	<!--
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	-->
	<link rel="icon" type="image/png" href="pics/favicon.ico">
	<title>Hangman</title>
</head>

<body>
	<?php
		include 'config.php';
		include 'functions.php';
		if (isset($_POST['newWord']))
			unset($_SESSION['answer']);
		if (!isset($_SESSION['answer'])){	//new game
			$_SESSION['attempts'] = 0;
			$_SESSION['wrong_guesses'] = '';
			
			echo '<img src="pics/6.jpg"><br />';
			
			$answer = fetchWordArray($WORDLISTFILE);

			$_SESSION['answer'] = $answer;
			
			//echo '$answer is ';	//DAK
			//foreach($answer as $value)	//DAK
			//	echo $value;	//DAK

			$_SESSION['hidden'] = hideCharacters($answer);
			//echo "_SESSION['hidden'] is ";	//DAK
			//foreach($_SESSION['hidden'] as $value2)	//DAK
			//	echo $value2;	//DAK

			echo 'Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts']).'<br />';
			echo 'Letters guessed wrong: <br />';
		}
		else{
			if (isset ($_POST['userInput'])){
				$userInput = $_POST['userInput'];
				$_SESSION['hidden'] = checkAndReplace(strtolower($userInput), $_SESSION['hidden'], $_SESSION['answer']);
				checkGameOver($MAX_ATTEMPTS,$_SESSION['attempts'], $_SESSION['answer'],$_SESSION['hidden']);
				echo '<img src="pics/'.($MAX_ATTEMPTS - $_SESSION['attempts']).'.jpg"><br />';
			}
			echo 'Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts'])."<br />";
			echo 'Letters guessed wrong: '.$_SESSION['wrong_guesses']."<br />";
		}
		$hidden = $_SESSION['hidden'];
		foreach ($hidden as $char){
			if($char == ' ')
				$char = "&nbsp;";
			echo $char."&nbsp;";
		}
		echo '<br />';
	?>

	<script type="application/javascript">
		function validateInput() {
			var x=document.forms["inputForm"]["userInput"].value;
			if (x == "" || !/^[a-zA-Z]*$/g.test(x)) {
				alert("You are only allowed to enter a letter.");
				document.forms["inputForm"]["userInput"].value = '';
				document.forms["inputForm"]["userInput"].focus();
				return false;
			}
		}
	</script>

	<form name = "inputForm" action = "" method = "post">
		Your Guess: <input name = "userInput" type = "text" size="1" maxlength="1" style="text-transform:uppercase" autofocus autocomplete="off"  />
		<input type = "submit" value = "Check" onclick="return validateInput()"/>
		<input type = "submit" name = "newWord" value = "Try another Word"/>
	</form>

</body>

</html>