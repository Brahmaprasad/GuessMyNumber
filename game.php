<?php
	session_start();
	if(!array_key_exists("guess", $_SESSION))
		$_SESSION["guess"] = rand(1,100);

	if($_GET){
		if(array_key_exists("exit", $_GET)){
			unset($_SESSION["guess"]);
			unset($_SESSION["player"]);
		}
		
		if(array_key_exists("player", $_GET)){
			$playername = $_GET["player"];
			if(!trim($playername) != "")
				header("Location:index.php");
			else{
				$_SESSION["user"] = $_GET["player"];
			}
		}
		else{

			header("Location:index.php");
		}
			
	}
	else
		header("Location:index.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Guess the Number</title>
  </head>
  <body>
	  	<div class="container">
			<div class="row">
				<div class="col-sm-2"><div id="guessHistory"></div></div>
				<div class="col-sm-8">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
					  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
						<a class="navbar-brand"><?php if(array_key_exists("player", $_GET)) echo "Welcome ".$_GET["player"]; ?></a>
						<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
						</ul>
						<form class="form-inline my-2 my-lg-0">
						  <button name="exit" class="btn btn-outline-danger my-2 my-sm-0" type="submit">Exit</button>
						</form>
					  </div>
					</nav>
					<form id="guessform" class="form-inline my-2 my-lg-0">
						<input id="guessinput" type="number" placeholder="00" autofocus autocomplete="off" min="1" max="100">
					</form>
					<div id="response"></div>
				</div>
			</div>
	    </div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  	<script>
			var guessHistory = [];
			var messages = ["Yaay, you got it!!!", "Your guess is less than my number", "Your guess is more than my number"]
	    	$("#guessform").submit(function(e){
				e.preventDefault();
				
				var systemGuess = <?php echo json_encode($_SESSION["guess"]);?>

				//if($("#guessinput").val() != "")
				if($("#guessinput").val().trim().length != 0){
					var userGuess = $("#guessinput").val();
					$.ajax({
					  method: "GET",
					  url: "validate.php",
					  data: { userGuess: userGuess, systemGuess : systemGuess}
					})
					.done(function( msg ) {
						if(msg == 0){
							$("#response").html('<div class="alert alert-success" role="alert">'+messages[0]+'</div>');
							$("#response").show();
						}
						else if(msg == -1){
							$("#response").html('<div class="alert alert-danger" role="alert">'+messages[1]+'</div>');
							$("#response").show();
							$("#guessinput").val("");
							guessHistory[guessHistory.length] = userGuess; 
						}
						else{
							$("#response").html('<div class="alert alert-danger" role="alert">'+messages[2]+'</div>');
							$("#response").show();
							$("#guessinput").val("");
							guessHistory[guessHistory.length] = userGuess; 
						}

						for(var i = 0 ; i < guessHistory.length; i++){
							if(i == 0)
								$("#guessHistory").html('<div class="alert alert-secondary" role="alert">'+guessHistory[i]+'</div>');
							else
								$("#guessHistory").html($("#guessHistory").html()+'<div class="alert alert-secondary" role="alert">'+guessHistory[i]+'</div>');
							
						if($('#guessHistory').children().last().html() < systemGuess)
							$('#guessHistory').children().last().html($('#guessHistory').children().last().html() + " &darr;");
						else if($('#guessHistory').children().last().html() > systemGuess)
							$('#guessHistory').children().last().html($('#guessHistory').children().last().html() + " &uarr;");
						}
					});
				}
			})
			
			$("#guessinput").change(function(){
				$("#response").hide();
			})
	    </script>
  </body>
</html>
