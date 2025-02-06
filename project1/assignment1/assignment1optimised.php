<!-- ### **Mini Project 1: Expense Tracker**
Create a program that allows a user to input their daily expenses for 7 days. The program should calculate and display:
1. The total expenses for the week.
2. The average daily expense.
3. The day with the highest expense and the day with the lowest expense. -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Expense Tracker</title>
</head> 
<body>
    <div id="form" class="container mt-5">
        <h1 class="mb-4">Daily Expense Tracker</h1>
        <form action="" method="GET">
            <?php 
                $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                foreach ($days as $index => $day) {
                    $value = isset($_GET["day$index"]) ? htmlspecialchars($_GET["day$index"]) : ''; 
                    echo '
                        <div class="mb-3">
                            <label for="day'.$index.'" class="form-label">'.$day.':</label>
                            <input type="number" name="day'.$index.'" class="form-control" placeholder="Expense for '.$day.'" min="0" value="'.$value.'">
                        </div>';
                }
            ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php 
    if (!empty($_GET)) {
        $expenses = array_map('intval', array_intersect_key($_GET, array_flip(array_map(fn($i) => "day$i", array_keys($days)))));
        
        if (!empty($expenses)) {
            $total = array_sum($expenses);
            $avg = (int) ($total / count($expenses));
            $max = max($expenses);
            $min = min($expenses);
            $max_day = array_keys($expenses, $max)[0];
            $min_day = array_keys($expenses, $min)[0];

            echo '
            <div id="result" class="container mt-4">
                <h2>Week\'s Total Expense: '.$total.'</h2>
                <h2>Week\'s Average Expense: '.$avg.'</h2>
                <h2>Minimum Expense Day: '.$days[$min_day].' ('.$min.')</h2>
                <h2>Maximum Expense Day: '.$days[$max_day].' ('.$max.')</h2>
            </div>';
        } else {
            echo '<div class="container mt-4 alert alert-warning">Please enter valid expenses.</div>';
        }
    }
    ?>
</body>
</html>


