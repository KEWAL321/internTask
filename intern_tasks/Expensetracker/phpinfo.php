<!-- ### **Mini Project 1: Expense Tracker**
Create a program that allows a user to input their daily expenses for 7 days. The program should calculate and display:
1. The total expenses for the week.
2. The average daily expense.
3. The day with the highest expense and the day with the lowest expense. -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <title>Document</title>
</head> 
<body>
    <div id="form">
        <h1>Daily expense tracker: </h1>
    <form action="/phpinfo.php" method="GET">
        <div id="day1">
        <label for="day1" id="label1">Sunday :</label>
        <input type="number" name="day1" placeholder="expense for sunday " id="day1" min="0" value="<?php echo isset($_GET["day1"]) ? $_GET["day1"] : ''; ?>">
        </div>

        <div id="day2">
        <label for="day2">Monday :</label>
        <input type="number" name="day2" placeholder="expense for monday " id="day2" min="0" value="<?php echo isset($_GET["day2"]) ? $_GET["day2"] : ''; ?>">
        </div>

        <div id="day3">
        <label for="day3">Tuesday :</label>
        <input type="number" name="day3" placeholder="expense for tuesday" id="day3" min="0" value="<?php echo isset($_GET["day3"]) ? $_GET["day3"] : ''; ?>">
        </div>

        <div id="day4">
        <label for="day4">Wednesday :</label>
        <input type="number" name="day4" placeholder="expense for wednesday" id="day4" min="0" value="<?php echo isset($_GET["day4"]) ? $_GET["day4"] : ''; ?>">
        </div>

        <div id="day5">
        <label for="day5">Thrusday</label>
        <input type="number" name="day5" placeholder="expense for thursday" id="day5" min="0" value="<?php echo isset($_GET["day5"]) ? $_GET["day5"] : ''; ?>">
        </div>

        <div id="day6">
        <label for="day6">Friday</label>
        <input type="number" name="day6" placeholder="expense for friday" id="day6" min="0" value="<?php echo isset($_GET["day6"]) ? $_GET["day6"] : ''; ?>">
        </div>

        <div id="day7">
        <label for="day7">Saturday</label>
        <input type="number" name="day7" placeholder="expense for saturday" id="day7" min="0" value="<?php echo isset($_GET["day7"]) ? $_GET["day7"] : ''; ?>">
        </div>

        <button type="submit" class="btn btn-primary" id="submit">submit</button>
    </form>
    </div>
    <?php 
    if(!empty($_GET)){
        // $name = $_GET["day1"];
        $min=$max=$_GET["day1"];
        $min_day=$max_day=$total=0;$avg;
        for($i= 1;$i<=count($_GET);$i++){
            $total += $_GET["day{$i}"];
            // $min = $min>$_GET["day{$i}"]?$_GET["day{$i}"]:$min;
            // ($min>=$_GET["day{$i}"]) && $min_day = $i && $min = $_GET["day{$i}"];

            if($max<=$_GET["day{$i}"]){
                $max = $_GET["day{$i}"];
                $max_day=$i;
            }

            if($min>=$_GET["day{$i}"]){
                $min = $_GET["day{$i}"];
                $min_day=$i;
            }

    $avg = (int)($total/count($_GET));
        }
        $days = array("Sunday","Monday","Tuesday","Wednesday","Thrusday","Friday","Saturday");
        echo '<div id="result">';
        echo "<h2>Week's total expense: $total <br>";
        echo "<h2>Week's average expense: $avg <br>";
        echo "<h2>Minimum expense day: $days[$min_day] <br>";
        echo "<h2>Maximum expense day: $days[$max_day] <br>";
        echo "</div>";
    }
  ?>
</body>
</html>



