<!DOCTYPE html>
<html>
<head>
	<title>Video Game Quiz!</title>
</head>

<!-- 

HOW TO: In the terminal, navigate to whatever directory this is in, and start a server using the following command:

php -S localhost:4000 (or whatever port you want to use)

For this command to work, you need to make sure you have php installed on your computer, and you need to make sure you set up the path variable for PHP.

-->

<?php 

	$points = 0; //Tally up the points at the end.
	$someAnswered = false; //Display a message if the exam was incomplete upon submission.
	$allAnswered = true; //Display the score iff the user has answered all questions.

	echo "<h1>Video Game Quiz! Can Real Adults Pass???</h1>";

	class Question {
		private $Ques; //The actual written question
		private $Choices = array(); //The choices
		private $Ans; //The correct answer

		function __construct($ques, $choices, $ans)
		{
			$this->Ques = $ques;
			$this->Choices = $choices;
			$this->Ans = min(sizeof($choices) - 1, abs($ans)); //Make sure the only possible answer indices are 0 through the possible number of choices minus 1.
		}

		//Getters

		public function getAnsNum() //Get the number of answers the question has.
		{
			return sizeof($this->Choices);
		}

		public function getAns() //Get the answer.
		{
			return $this->Choices[$this->Ans];
		}

		public function getChoice($choice) //Display any of the choices in a question with the choice index.
		{
			return $this->Choices[$choice];
		}

		public function getQues() //Get the question.
		{
			return $this->Ques;
		}
	}

	//Some questions...

	$questions = array(new Question("Who made Dark Souls?", array("Nintendo", "From Software", "Hideo Kojima", "EA"), 1), new Question("Who voiced Isaac Clark?", array("Troy Baker", "Nathan Fillion", "Nolan North", "Gunnar Wright"), 3), new Question("Which Batman game received the Game of the Year award?", array("Arkham Asylum", "Arkham City", "Arkham Origins", "Arkham Knight"), 1), new Question("Who is the most useless character in Smash?", array("Jigglypuff", "Mr. Game-and-Watch", "Captain Olimar"), 0), new Question("Who is the most unfair character in Smash?", array("Ike", "Wolf", "Palutena"), 1), new Question("Which software was used to make Dead Cells?", array("Unity", "Construct2", "Stencyl", "None! Homemade C++!"), 3), new Question("What is the name of Super Meat Boy's girlfriend?", array("Super Meat Girl", "Super Vegetable Girl", "Bandage Girl"), 3), new Question("In what video game did Jack Black voiceact?", array("Crash Bandicoot", "Call of Duty: Black Ops 2", "Brutal Legend", "Grand Theft Auto IV"), 2), new Question("Which Doom game has the most jump scares?", array("Doom 2", "Doom 3", "Doom: 2016", "Doom: Eternal"), 1), new Question("What are the five combat spells of GARALT AHV RIVIA?", array("Igni, Quen, Vahn, Yrden, and Axii", "Ignys, Quen, Aard, Axii, and Yrden", "Igni, Axii, Yrden, Quen, and Aard", "Igni, Quon, Ard, Yrden, and Axii"), 2));

	echo "<form action = 'gamequiz.php' method = 'post'>";

	//Display the questions and their possible answers.
	
	for ($i = 0; $i < sizeof($questions); $i++)
	{
		echo $questions[$i]->getQues() . "<br>";

		for ($j = 0; $j < $questions[$i]->getAnsNum(); $j++)
		{
			echo "<input type='radio' name=$i value='" . $questions[$i]->getChoice($j) . "'>" . $questions[$i]->getChoice($j) . "<br>";
		}

		echo "<br>";
	}

	echo "<input type='submit'></form><br>";

	for ($i = 0; $i < sizeof($questions); $i++)
	{
		if ($_POST[$i] != "")
		{
			$someAnswered = true;
		}

		else if ($_POST[$i] == $questions[$i]->getAns())
		{
			$points++;
		}

		else
		{
			$allAnswered = false;
		}
	}

	if ($allAnswered)
	{
		echo "Final Score: " . $points . "/" . sizeof($questions) . "<br><br>";

		if ($points < 8)
		{
			echo "<h1>YOU SUCK<h1>";
		}

		else
		{
			echo "Congrats!";
		}
	}

	else if ($someAnswered)
	{
		echo "Answer all of them, first!  Press the back button to pick up where you left off.";
	}

	else
	{
		echo "Submit all answers to receive your score...";
	}
?>

</html>