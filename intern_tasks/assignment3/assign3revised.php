<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div id="form-no" class="container mt-5">
    <form action="/assignment3/assignment3optimised.php" method="GET">
        <label for="students" class="form-label">enter number of students : </label>
        <input type="number" name="students" id="students" value="<?php echo isset($_GET["students"])?$_GET["students"]:'' ;?>" class="form-control"><br>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
    </div>



<?php
function student_input($num){
    echo '<form action="/assignment3optimised.php?students='.$num.'" method="POST">';
    for($i=1;$i<=$num;$i++){
        //WAY2
        echo '
        <div id="form.$i" class="container" >
        <h2>Student'.$i.'</h2>
        <label for="name'.$i.'">name: </label>
        <input type="text" name="name[]" id="name'.$i.'"><br><br>
        <label for="score'.$i.'">score: </label>
        <input type="number" name="score[]" id="score'.$i.'" max="100" min="1">';
}
echo '<br><br>';
    echo '<button type="submit">Submit</button>';
    echo '</form>';
}

if(isset($_GET['students'])){
    $num = $_GET['students'];
    student_input($num);
}
?>

<?php 
//WAY2
if(isset($_POST)){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $names = $_POST["name"];
    $scores = $_POST["score"];

    $min_index=$max_index=$max_score=$num=$above_average=0;
    $min_score=101;
    foreach($scores as $index => $value){

        if($max_score<=$value){
            $max_score = $value;
            $max_index=$index;
        }

        if($min_score>=$value){
            $min_score = $value;
            $min_index=$index;
        }
        $num++;
    }
    $avg = (float)(array_sum($scores)/$num);
    $above_average = count(array_filter($scores,function($score)use($avg){
        return $score > $avg;
    }));

    echo "<h2>The average expense of the week is $avg <br>";
    echo "<h2>The day of minimum score is $min_score by $names[$min_index]<br>";
    echo "<h2>The day of maximum score is $max_score by $names[$max_index] <br>";
    echo "<h2>$above_average students scored above average scores<br>";
}
}
?>

</body>
</html>