<?php
	$countriesArray = [];	//holds each line of the text file in each cell

	function populateArrayFromFile($countries_file/*, $local_countries_array*/){
		$local_countries_array = [];
		$file = new SplFileObject($countries_file);	//file to read the countries from

		foreach($file as $line)
			array_push($local_countries_array, trim($file->current()));	//store the countries from the file into the countries_array
		
		return $local_countries_array;
	}
	
	function fetchWordArray($wordFile){
		global $countriesArray;
		if(count($countriesArray) == 0)	//if we have not read from the file yet, read from the file and store into an array
			$countriesArray = populateArrayFromFile($wordFile);
		
		$random_key=array_rand($countriesArray);
		$answer = str_split(strtoupper($countriesArray[$random_key]));
		
		return $answer;
	}

	function hideCharacters($answer){
		$hidden = $answer;
		foreach ($hidden as &$value)
			if($value != ' ')
				$value = '_';
		unset($value); // break the reference with the last element
		
		return $hidden;
	}

	function checkAndReplace($userInput, $hidden, $answer){
		$wrongGuess = true;
		$userInput = strtoupper($userInput);
		$cnt = count($answer);
		for ($i = 0; $i < $cnt; $i++)
			if($answer[$i] == $userInput){
				$hidden[$i] = $userInput;
				$wrongGuess = false;
			}

		if ($wrongGuess && strpos($_SESSION['wrong_guesses'], $userInput) === false ){	//if the guess is wrong and it is a new wrong guess, then add it to the wrong guesses string
			$_SESSION['attempts'] ++;
			$_SESSION['wrong_guesses'] .= ($_SESSION['wrong_guesses'] == '' ? $userInput : (', '.$userInput));
		}

		return $hidden;
	}

    function checkGameOver($MAX_ATTEMPTS,$userAttempts, $answer, $hidden){
		if ($userAttempts >= $MAX_ATTEMPTS){
			echo '<img src="pics/0.jpg"><br />';
			echo "You lost. The correct word was ";
			foreach ($answer as $letter)
				echo $letter;
			echo '<br /><br /><form action = "" method = "post"><input type = "submit" name = "newWord" value = "Try another Word" autofocus/></form><br />';
			die();
		}
		if (count(array_diff($hidden, $answer)) == 0){
			echo '<img src="pics/'.($MAX_ATTEMPTS - $_SESSION['attempts']).'.jpg"><br />';
			echo "You won. The correct word was indeed ";
			foreach ($answer as $letter)
				echo $letter;
			echo '<br /><br /><form action = "" method = "post"><input type = "submit" name = "newWord" value = "Try another Word" autofocus/></form><br />';
			die();
		}
	}
?>
