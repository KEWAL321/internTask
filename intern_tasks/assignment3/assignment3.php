<!-- ### **Mini Project 3: Student Grade Analyzer**
Create a program that manages and analyzes grades for a class of students. The program should:
1. Ask the user to input the number of students in the class.
2. For each student, ask for their name and their score (out of 100).
3. Store the student names and scores in a way that allows you to:
   - Calculate the average score for the class.
   - Find the highest score and the name of the student who achieved it.
   - Find the lowest score and the name of the student who achieved it.
   - Count how many students scored above the average.
4. Display the results in a clear and organized way. -->


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>

    <form action="/assignment3.php" method="GET">
        <label for="students">enter number of students : </label>
        <input type="number" name="students" id="students" value="<?php echo isset($_GET["students"])?$_GET["students"]:'' ;?>"><br>
        <button type="submit">Submit</button>
    </form>



<?php
function student_input($num){
    echo '<form action="/assignment3.php?students='.$num.'" method="POST">';
    for($i=1;$i<=$num;$i++){
        // WAY1
        echo '
        <h2>Student'.$i.'</h2>
        <label for="name'.$i.'">name: </label>
        <input type="text" name="name'.$i.'" id="name'.$i.'"><br><br>
        <label for="score'.$i.'">score: </label>
        <input type="number" name="score'.$i.'" id="score'.$i.'" max="100" min="1" step="0.5">';
}
echo '<br><br>';
    echo '<button type="submit">Submit</button>';
    // echo '<button type="submit" name="submit">Submit</button>';
    echo '</form>';
}

if(isset($_GET['students'])){
    $num = $_GET['students'];
    student_input($num);
}
?>

<?php 
//WAY1
if(isset($_POST)){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $min_name=$max_name=$_POST["name1"];
    $min_score=101;$max_score=$total=$num=$above_average=0;
    foreach($_POST as $key => $value){

        if (strpos($key, 'name') !== false) {
            continue;
        }
        $total += (int)$value;

        $student_number = str_replace("score", "", $key);
        $student_name = $_POST["name" . $student_number];


        if($max_score<=$value){
            $max_score = $value;
            $max_name=$student_name;
        }

        if($min_score>=$value){
            $min_score = $value;
            $min_name=$student_name;
        }
        $num++;
    }
    $avg = (float)($total/$num);
    
    $filtered = array_filter($_POST, function($key) {
        return stripos($key, "score") !== false;
    }, ARRAY_FILTER_USE_KEY);
    
    $renamed = [];
    foreach ($filtered as $key => $value) {
        $newKey = str_replace("score", "", $key); 
        $renamed[$newKey] = $value;
        $value>$avg && $above_average++;
    }
    
    print_r($renamed);

    echo "<h2>The average expense of the week is $avg <br>";
    echo "<h2>The day of minimum score is $min_score by $min_name<br>";
    echo "<h2>The day of maximum score is $max_score by $max_name <br>";
    echo "<h2>$above_average students scored above average scores<br>";
}
}

?>


</body>
</html>