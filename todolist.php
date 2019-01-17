<!DOCTYPE html>
<html>
<head>
	<title>To Do List!</title>
</head>
<?php 

	//Assume preexisting database and table...

	$conn = new mysqli("localhost", "root", "d4748453", "userDB");
	$idToProvide = 0;
	$task = '';
	$duration = '';

	if ($conn->connect_error) 
	{
    	die("Connection failed: " . $conn->connect_error);
	} 

	echo "<h1>To Do List</h1>";
	echo "<form action = 'todolist.php' method = 'post'>";
	echo "Task: <input type = 'text' name = 'task'><br><br>";
	echo "Duration: <input type = 'text' name = 'duration'>"; 
	echo " (in minutes; non-integers resulting in invalid database queries will not be added to the list)<br><br>";
	echo "<input type='submit'></form>";

	if (isset($_POST['task']))
	{
		$task = addslashes($_POST['task']); //Make sure difficult characters work properly (e.g, apostrophes; slashes needed);
	}

	if (isset($_POST['duration']))
	{
		$duration = $_POST['duration'];
	}

	$idToProvide =  mysqli_fetch_row($conn->query("select count(0) from userlist;"))[0];
	$conn->query("insert into userlist values ('$idToProvide', '$task', '$duration');");

	echo "<form action = 'todolist.php' method = 'post'>";

	for ($i = 0; $i < mysqli_fetch_row($conn->query("select count(0) from userlist;"))[0]; $i++) //You need to fetch the row, again.  $idToProvide will be outdated.
	{
		echo "<br>Task: " . mysqli_fetch_row($conn->query("select * from userlist where id = '$i';"))[1] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duration: " . mysqli_fetch_row($conn->query("select * from userlist where id = '$i';"))[2] . " minutes";
		echo "&nbsp;&nbsp;&nbsp;<input type = 'checkbox' name = 'delete[]' value='$i'><br>"; //Checkboxes need to be a part of an array if you want to delete more than one at a time, hence delete[].
	}

	echo "<br><input type = 'submit' name = 'submit' value = 'Delete Checked Items'></form>";

	if(isset($_POST['submit']) && !empty($_POST['delete']))
	{
		foreach($_POST['delete'] as $delete)
		{
			$conn->query("delete from userlist where id = '$delete';");  //Write actual query to delete the items.
		}

		//Change the ids so they're all consecutive numbers increasing by 1

		$conn->query("select * from userlist order by id;"); //Order them first...
		$conn->query("set @count = -1;"); //Create a variable in mysql for adjusting the ids..
		$conn->query("update userlist set id = @count := @count + 1;"); //Assign count to count + 1, then set the id equal to count...
		$conn->query("alter table id auto_increment;"); //Use auto_increment to assign consecutive numbers to ids...
		header("Refresh:0");
	}
?>
</html>