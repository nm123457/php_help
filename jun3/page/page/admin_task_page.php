<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Connect to the SQLite database
$db = new PDO('sqlite:../../tmp/v2_database.db');

// Get filter parameters from the request
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';
$complaintFilter = isset($_GET['complaint']) ? $_GET['complaint'] : '';
$fromDateFilter = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$toDateFilter = isset($_GET['to_date']) ? $_GET['to_date'] : '';

// Build the query with filters
$query = "SELECT * FROM tasks WHERE 1=1";
$params = [];

if ($typeFilter) {
    $query .= " AND type = :type";
    $params[':type'] = $typeFilter;
}
if ($complaintFilter) {
    $query .= " AND complaint LIKE :complaint";
    $params[':complaint'] = '%' . $complaintFilter . '%';
}
if ($fromDateFilter) {
    $query .= " AND filed_at >= :from_date";
    $params[':from_date'] = str_replace('T', ' ', $fromDateFilter);
}
if ($toDateFilter) {
    $query .= " AND filed_at <= :to_date";
    $params[':to_date'] = str_replace('T', ' ', $toDateFilter);
}

$stmt = $db->prepare($query);
//echo $query;
$stmt->execute($params);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Functions to calculate date ranges
function getCurrentDatetime() {
    return date('Y-m-d\T23:59');
}

function getTodayStart() {
    return date('Y-m-d\T00:00:00');
}

function getWeekStart() {
    return date('Y-m-d\T00:00:00', strtotime('monday this week'));
}

function getMonthStart() {
    return date('Y-m-01\T00:00:00');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feladatok</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
	<div class="admin-container">
	<div class="admin-box">
    <h1>Feladatok listája</h1>
    <div>
	<form class="button-form" action="create_task_page.php" method="post">
			<button type="submit">Feladat létrehozása</button>
	</form>
	<form class="button-form" action="downloadTasksAsCSV.php" method="post">
			<input type="hidden" name="tasks" id="tasksInput" value='<?php echo json_encode($tasks); ?>'>
			<button type="submit">Adatok exportálása CSV-be</button>
	</form>
	<form class="button-form" action="chart_page.php" method="post">
			<input type="hidden" name="tasks" id="tasksInput" value='<?php echo json_encode($tasks); ?>'>
			<button type="submit">Diagram oldal</button>
	</form>
	</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Létrehozó</th>
                <th>Befejezés dátum</th>
                <th>Létrehozás dátum</th>
                <th>Csatolt fájl</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['id']) ?></td>
                    <td><?= htmlspecialchars($task['task_name']) ?></td>
                    <td><?= htmlspecialchars($task['created_by']) ?></td>
                    <td><?= str_replace('T', ' ', htmlspecialchars($task['due_date'])); ?></td>
                    <td><?= htmlspecialchars($task['created_at']) ?></td>
                    <td><a href="download.php?file=<?= urlencode($task['attached_file_name']) ?>"><?= htmlspecialchars($task['attached_file_name']) ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function setDateRange(range) {
            const fromDateField = document.getElementById('from_date');
            const toDateField = document.getElementById('to_date');
            const todayStart = '<?= getTodayStart() ?>';
            const currentDatetime = '<?= getCurrentDatetime() ?>';
            const weekStart = '<?= getWeekStart() ?>';
            const monthStart = '<?= getMonthStart() ?>';

            if (range === 'today') {
                fromDateField.value = todayStart;
                toDateField.value = currentDatetime;
            } else if (range === 'week') {
                fromDateField.value = weekStart;
                toDateField.value = currentDatetime;
            } else if (range === 'month') {
                fromDateField.value = monthStart;
                toDateField.value = currentDatetime;
            }
        }

        function clearFilters() {
            document.getElementById('type').value = '';
            document.getElementById('complaint').value = '';
            document.getElementById('from_date').value = '';
            document.getElementById('to_date').value = '';
        }

        function setComplaintText(text) {
            document.getElementById('complaint').value = text;
        }
    </script>
	</div>
	</div>
</body>
</html>
