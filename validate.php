<?php
	$messages = array("You got it!!!", "Your guess is smaller than my number", "Your guess is larger than my number");
	if($_GET){
		$userGuess = $_GET["userGuess"];
		$systemGuess = $_GET["systemGuess"];
		$response = array("");
		if($userGuess==$systemGuess){
			echo 0;
		} elseif($userGuess < $systemGuess){
			echo -1;
		} else {
			echo 1;
		}
	}
?>