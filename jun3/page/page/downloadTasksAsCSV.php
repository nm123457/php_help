<?php

function downloadTasksAsCSV($tasks) {
    // Set the headers for the CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="tasks.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write the CSV column headers
    fputcsv($output, ['ID', 'task_name', 'created_by', 'due_date', 'created_at', 'attached_file_name'], ';');

    // Write each task as a row in the CSV
    foreach ($tasks as $task) {
        fputcsv($output, [
            $task['id'],
            $task['task_name'],
            $task['created_by'],
            $task['due_date'],
            $task['created_at'],
            $task['attached_file_name']
        ], ';');
    }

    // Close output stream
    fclose($output);
}

if (isset($_POST['tasks'])) {
    // Decode the JSON tasks array
    $tasks = json_decode($_POST['tasks'], true);

    // Call the function to download the CSV
    downloadTasksAsCSV($tasks);
} else {
    echo "No tasks data provided.";
}

?>
