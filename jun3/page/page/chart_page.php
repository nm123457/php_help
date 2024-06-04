<?php


if (isset($_POST['tasks'])) {
  $tasks = json_decode($_POST['tasks'], true);

  $tasksPerUser = [];
  foreach ($tasks as $task) {
    $createdBy = $task['created_by'];
    if (!isset($tasksPerUser[$createdBy])) {
      $tasksPerUser[$createdBy] = 0;
    }
    $tasksPerUser[$createdBy]++;
  }
} else {
  echo "No tasks data provided.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feladatok</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
        canvas {
            max-width: 400px;
            max-height: 400px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
  <div class="admin-container">
    <div class="admin-box" id="test22">
      <h1>Diagram</h1>
      <canvas id="chart1"></canvas>
      <script>
        <?php
        $usernames = array_keys($tasksPerUser);
        $taskCounts = array_values($tasksPerUser);
        ?>
        const taskLabels = <?php echo json_encode($usernames); ?>;
        const taskData = <?php echo json_encode($taskCounts); ?>;

        function createChart(ctx, labels, data, label, color, chartColors) {
          const chart = new Chart(ctx, {
            type: 'pie',  
            data: {
              labels: labels,
              datasets: [{
                label: label,
                data: data,
                backgroundColor: chartColors,
                borderColor: color,
                borderWidth: 1
              }]
            },
            options: {}
          });
        }
		
		function randomize_colors(elements) {
			let bgColors = [];
			for (let i = 0; i < elements.length; i++) {
				const n1 = Math.floor(Math.random() * 256);
				const n2 = Math.floor(Math.random() * 256);
				const n3 = Math.floor(Math.random() * 256);
				bgColors[i] = "rgb(" + n1 + ", " + n2 + ", " + n3 + ")";
			}
			return bgColors;
		}

        createChart(document.getElementById('chart1'), taskLabels, taskData, 'Tasks per user', 'rgba(255, 99, 132, 0.5)', randomize_colors(taskLabels));
      </script>
    </div>
  </div>
</body>
</html>
