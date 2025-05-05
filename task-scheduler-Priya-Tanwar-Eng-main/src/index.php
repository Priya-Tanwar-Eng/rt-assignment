<?php
// Make sure functions.php is included properly with error checking
$functions_file = __DIR__ . '/functions.php';
if (file_exists($functions_file)) {
    require_once $functions_file;
} else {
    die("Error: functions.php file not found. Please check the file path: $functions_file");
}

// Add tasks when form is submitted
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

// Handle task deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-task-id'])) {
    deleteTask($_POST['delete-task-id']);
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh to avoid resubmission
    exit;
}

// Handle task status updates with PHP
if (isset($_POST['update-task-status']) && isset($_POST['task-id'])) {
    $taskId = $_POST['task-id'];
    // If checkbox is checked, its value will be present in $_POST
    $isCompleted = isset($_POST['task-status']) ? '1' : '0';
    
    // Call function to update task status
    markTaskAsCompleted($taskId, $isCompleted);
    
    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        #task-name {
            padding: 8px;
            width: 70%;
            margin-right: 10px;
        }
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .delete-task {
            background-color: #f44336;
            margin-left: 10px;
        }
        .delete-task:hover {
            background-color: #d32f2f;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        .task-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
        }
        .task-status {
            margin-right: 10px;
        }
        .task-name {
            flex-grow: 1;
        }
        .completed {
            text-decoration: line-through;
            color: #888;
        }
        .subscription-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        #email {
            padding: 8px;
            width: 60%;
            margin-right: 10px;
        }
        .checkbox-form {
            display: inline;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h1>Task Manager</h1>
    
    <!-- Add Task Form -->
    <form method="POST" action="">
        <input type="text" name="task-name" id="task-name" placeholder="Enter new task" required>
        <button type="submit" id="add-task">Add Task</button>
    </form>
   
    <!-- Tasks List -->
    <h2>Your Tasks</h2>
    <ul id="tasks-list">
        <?php
        $tasks = getAllTasks();
        if (!empty($tasks)) {
            foreach ($tasks as $task) {
                $isChecked = $task['status'] === '1' ? 'checked' : '';
                $completedClass = $task['status'] === '1' ? 'completed' : '';
                echo "<li class='task-item'>
                        <form method='POST' action='' class='checkbox-form'>
                            <input type='hidden' name='task-id' value='{$task['id']}'>
                            <input type='hidden' name='update-task-status' value='1'>
                            <input type='checkbox' name='task-status' class='task-status' $isChecked onchange='this.form.submit()'>
                        </form>
                        <span class='task-name $completedClass'>{$task['name']}</span>
                        <form method='POST' action='' style='display:inline;'>
                            <input type='hidden' name='delete-task-id' value='{$task['id']}'>
                            <button type='submit' class='delete-task'>Delete</button>
                        </form>
                      </li>";
            }
        } else {
            echo "<p>No tasks yet. Add a task above!</p>";
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