<?php
require_once 'functions.php';

// TODO: Implement the task scheduler, email form and logic for email registration.

// In HTML, you can add desired wrapper `<div>` elements or other elements to style the page. Just ensure that the following elements retain their provided IDs.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task-name'])) {
        $task = $_POST['task-name'];
        if (addTask($task)) {
            echo "<p style='color:green;'> Task added successfully!</p>";
        } else {
            echo "<p style='color:red;'> Failed to add task. Try again.</p>";
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
	<!-- Implement Header !-->
</head>

<body>

	<!-- Add Task Form -->
	<form method="POST" action="">
		<!-- Implement Form !-->
		<input type="text" name="task-name" id="task-name" placeholder="Enter new task" required>
		<button type="submit" id="add-task">Add Task</button>
	</form>

	<!-- Tasks List -->
	<ul id="tasks-list">
		<!-- Implement Tasks List (Your task item must have below
		provided elements you can modify there position, wrap them
		in another container, or add styles but they must contain
		specified classnames and input type )!-->
		<?php
$tasks = getAllTasks();
if (!empty($tasks)) {
    foreach ($tasks as $task) {
        echo "<li class='task-item'>
                <input type='checkbox' class='task-status' " . ($task['status'] === '1' ? 'checked' : '') . ">
                <span class='task-name'>{$task['name']}</span>
                <form method='POST' action='' style='display:inline;'>
                    <input type='hidden' name='delete-task-id' value='{$task['id']}'>
                    <button type='submit' class='delete-task'>Delete</button>
                </form>
              </li>";
    }
}
?>	
	</ul>

	<!-- Subscription Form -->
	<form method="POST" action="">
		<!-- Implement Form !-->
		<button type="submit" id="submit-email">Subscribe</button>
	</form>

</body>

</html>
