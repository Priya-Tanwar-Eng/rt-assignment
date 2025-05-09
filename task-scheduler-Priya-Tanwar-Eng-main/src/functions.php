<?php

/**
 * Adds a new task to the task list
 * 
 * @param string $task_name The name of the task to add.
 * @return bool True on success, false on failure.
 */

function addTask(string $task_name): bool {
    $file = __DIR__ . '/tasks.txt';
    $task = trim($task_name);
    if (empty($task)) return false;

    $task_id = uniqid(); // Unique ID
    $status = '0'; // Not completed

    $line = $task_id . '|' . $status . '|' . $task;

    $handle = fopen($file, 'a');
    if ($handle === false) return false;

    fwrite($handle, $line . PHP_EOL);
    fclose($handle);
    return true;
}

/**
 * Retrieves all tasks from the tasks.txt file
 * 
 * @return array Array of tasks.
 */
function getAllTasks(): array {
    $file = __DIR__ . '/tasks.txt';

    if (!file_exists($file)) {
        return [];
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $tasks = [];

    foreach ($lines as $line) {
        $parts = explode('|', $line);
        if (count($parts) === 3) {
            $tasks[] = [
                'id' => $parts[0],
                'status' => $parts[1],
                'name' => $parts[2]
            ];
        }
    }

    return $tasks;
}

/**
 * Marks a task as completed or uncompleted
 * 
 * @param string  $task_id The ID of the task to mark.
 * @param bool $is_completed True to mark as completed, false to mark as uncompleted.
 * @return bool True on success, false on failure
 */
function markTaskAsCompleted( string $task_id, bool $is_completed ): bool {
	$file  = __DIR__ . '/tasks.txt';
	// TODO: Implement this function

	if (!file_exists($file)) {
        return false;
    }
    
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $updated = false;
    
    foreach ($lines as $index => $line) {
        $parts = explode('|', $line);
        if (count($parts) === 3 && $parts[0] === $task_id) {
            $parts[1] = $is_completed ? '1' : '0'; // Update status
            $lines[$index] = implode('|', $parts);
            $updated = true;
            break;
        }
    }
    
    if (!$updated) {
        return false; // Task not found
    }
    
    // Write updated lines back to the file
    $handle = fopen($file, 'w');
    if ($handle === false) {
        return false;
    }
    
    foreach ($lines as $line) {
        fwrite($handle, $line . PHP_EOL);
    }
    
    fclose($handle);
    return true;
}

/**
 * Deletes a task from the task list
 * 
 * @param string $task_id The ID of the task to delete.
 * @return bool True on success, false on failure.
 */
function deleteTask(string $task_id): bool {
    $file = __DIR__ . '/tasks.txt';

    if (!file_exists($file)) {
        return false;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $new_lines = [];

    foreach ($lines as $line) {
        $parts = explode('|', $line);
        if (count($parts) === 3 && $parts[0] !== $task_id) {
            $new_lines[] = $line;
        }
    }

    $handle = fopen($file, 'w');
    if ($handle === false) {
        return false;
    }

    foreach ($new_lines as $line) {
        fwrite($handle, $line . PHP_EOL);
    }

    fclose($handle);
    return true;
}


/**
 * Generates a 6-digit verification code
 * 
 * @return string The generated verification code.
 */
function generateVerificationCode(): string {
	// TODO: Implement this function
}

/**
 * Subscribe an email address to task notifications.
 *
 * Generates a verification code, stores the pending subscription,
 * and sends a verification email to the subscriber.
 *
 * @param string $email The email address to subscribe.
 * @return bool True if verification email sent successfully, false otherwise.
 */
function subscribeEmail( string $email ): bool {
	$file = __DIR__ . '/pending_subscriptions.txt';
	// TODO: Implement this function
}

/**
 * Verifies an email subscription
 * 
 * @param string $email The email address to verify.
 * @param string $code The verification code.
 * @return bool True on success, false on failure.
 */
function verifySubscription( string $email, string $code ): bool {
	$pending_file     = __DIR__ . '/pending_subscriptions.txt';
	$subscribers_file = __DIR__ . '/subscribers.txt';
	// TODO: Implement this function
}

/**
 * Unsubscribes an email from the subscribers list
 * 
 * @param string $email The email address to unsubscribe.
 * @return bool True on success, false on failure.
 */
function unsubscribeEmail( string $email ): bool {
	$subscribers_file = __DIR__ . '/subscribers.txt';
	// TODO: Implement this function
}

/**
 * Sends task reminders to all subscribers
 * Internally calls  sendTaskEmail() for each subscriber
 */
function sendTaskReminders(): void {
	$subscribers_file = __DIR__ . '/subscribers.txt';
	// TODO: Implement this function
}

/**
 * Sends a task reminder email to a subscriber with pending tasks.
 *
 * @param string $email The email address of the subscriber.
 * @param array $pending_tasks Array of pending tasks to include in the email.
 * @return bool True if email was sent successfully, false otherwise.
 */
function sendTaskEmail( string $email, array $pending_tasks ): bool {
	$subject = 'Task Planner - Pending Tasks Reminder';
	// TODO: Implement this function
}
