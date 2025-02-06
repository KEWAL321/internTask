<?php
// function initializationForm(){
//     echo "<div id='form' class='container mt-5'>
//             <form action='/assignment6/phase1.php' method='GET'>
//                 <h1 class='top_h1'>Enter number of </h1>
//                 <label for='students' class='form-label'>
//                     <h1>Students: </h1>
//                 </label>

//                 <input type='number' name='students' id='students' 
//                             value=";if(isset($_GET['students'])){
//                             $_GET['students'];
//                             }
//                             elseif(!empty($_SESSION['marks'])){

//                                 $students = $_SESSION['marks'];
//                                 echo count($students);
//                             }
//                             else{
//                                 echo '';
//                             }
//     echo "class='form-control' required><br>

//                 <label for='subjects' class='form-label'>
//                     <h1>Subjects: </h1>
//                 </label>
//                 <input type='number' name='subjects' id='subjects'
//                     value=";if(isset($_GET['subjects'])){
//                                 echo $_GET['subjects'];
//                             }
//                             elseif(!empty($_SESSION['subjects'])){
//                                 $subjects = $_SESSION['subjects'];
//                                 echo count($subjects);
//                             }
//                             else{
//                                 echo '';
//                             }
//     echo "class='form-control' required><br>
//                 <button type='submit' class='btn btn-primary mt-4'>Submit</button>
//             </form>

//             <form action='/assignment6/phase1.php' class='container mt-5' method='POST' enctype='multipart/form-data'>
//                 <label for='inputCsv'>Choose a csv file: </label><br>
//                 <input type='file' id='inputCsv' name='csvFile' accept='.csv'  required>
//                 <button type='submit' class='btn btn-primary mt-4'>Submit</button>
//             </form>
//         </div>";
// }

function showMainForm($numOfStd, $numOfSub,$subjectsArray,$studentsNameArray, $scores = []){
    echo "<div id='form_students' class='container mt-5'>
    <form action='/assignment6/phase1.php?students='$numOfStd&subjects=$numOfSub' method='POST'>";

    echo "<input hidden name='subjectNEXT' value= " . json_encode($subjectsArray) . "> ";// to keep values even after submitting
    for ($i = 0; $i < $numOfStd; $i++) {
        echo '<h2>Student ' . $studentsNameArray[$i] . '</h2>';
        for ($j = 0; $j < $numOfSub; $j++) 
        {
            $scoreValue = isset($scores[$i][$j]) ? $scores[$i][$j] : '';
            echo "<div class='mt-5'><input type='number' name='score[$i][$j]' max='100' min='1' step='0.5' class='form-control' placeholder='Enter $subjectsArray[$j] score' value=" . (isset($_SESSION['score'])?$_SESSION['score'][$i][$j]:'') . " required> <hr></div>";
        }
    }
    echo '<button type="submit" class="btn btn-primary">Submit</button></form></div>';

}

function showSubForm($numOfSub, $numOfStd, $subjects = [])
{
    echo '<div id="form_subjects_students" class="container mt-5">';
    echo "<form action='/assignment6/phase1.php?students=$numOfStd&subjects=$numOfSub' method='POST'>";
    echo '<h2>Enter students Name: </h2>';

    for ($i = 0; $i < $numOfStd; $i++) {
    
        echo "<div class='mt-5'><input type='text' name='studentsNameArray[]' id='subject' class='form-control' placeholder='Name for student ".($i+1)."' value='" . (isset($_SESSION['studentsNameArray'])?$_SESSION['studentsNameArray'][$i]:'') . "' required>";
        isset($_SESSION['studentsNameArray']);
    }

    echo '<br><br>';

    echo '<h2>Enter subjects Name: </h2>';

    for ($i = 0; $i < $numOfSub; $i++) {
    
        echo "<div class='mt-5'><input type='text' name='subjectsArray[]' id='subject' class='form-control' placeholder='Name for subject ".($i+1)."' value='" . (isset($_SESSION['subjectsArray'])?$_SESSION['subjectsArray'][$i]:'') . "' required>";
        isset($_SESSION['subjectsArray']);
    }

    echo '<button type="submit" class="btn btn-primary">Submit</button></form></div>';
}


function showMainFormSession($totalSubjects,$totalStudents,$subjectsArray,$marksArray){
    echo "<div id='form_students' class='container mt-5'>
    <form action='/assignment6/phase1.php' method='POST'>";

    for ($i = 0; $i < $totalStudents; $i++) {
        echo '<h2>Student ' . $i + 1 . '</h2>';
        for ($j = 0; $j < $totalSubjects; $j++) 
        {
            $scoreValue = isset($marksArray[$i][$j]) ? $marksArray[$i][$j] : '';
            echo "<div class='mt-5'><input type='number' name='score[$i][$j]' max='100' min='1' step='0.5' class='form-control' placeholder='Enter $subjectsArray[$j] score' value=" . (isset($_SESSION['score'])?$_SESSION['score'][$i][$j]:'') . " required> <hr></div>";
        }
    }
    echo '<button type="submit" name="mainFormButton" class="btn btn-primary">Submit</button></form></div>';

    //shows table when main form submit button is clicked
    if(isset($_POST['score'])&& !empty($_SESSION['subjectsArray'])&&!empty($_SESSION['score'])){
        if(isset($_POST["mainFormButton"])){
            $subjectsArray = $_SESSION["subjectsArray"];
            $scoreArray = $_SESSION["score"];
            createTable($subjectsArray,$scoreArray);
        }
    }
}

function showSubFormSession($totalSubjects,$totalStudents,$subjectsArray,$marksArray)
{
    echo '<div id="form_subjects" class="container mt-5">';
    echo "<form action='/assignment6/phase1.php' method='POST'>";
    for ($i = 0; $i < $totalSubjects; $i++) {
        echo '<br>';
    
        echo "<div class='mt-5'><input type='text' name='subjectsArray[]' id='subject' class='form-control' placeholder='Enter name for subject ".($i+1)."' value='" . (isset($_SESSION['subjectsArray'])?$_SESSION['subjectsArray'][$i]:'') . "' required>";
        isset($_SESSION['subjectsArray']);
    }

    echo '<button type="submit" class="btn btn-primary">Submit</button></form></div>';
    showMainFormSession($totalSubjects,$totalStudents,$subjectsArray,$marksArray);
    
}


function displayExportBtn()
{
    echo "<div>";
    echo '<form action="" method="POST">';
    echo "<input type='hidden' name='exportToCsv'>";
    echo '<button type="submit" class="btn btn-primary">Export to CSV</button>';
    echo '</form>';
    echo '</div>';
}

function export_to_csv($subjects,$scores)//no of students,subjects and scores are required
{   
    $headers=[];
    
    foreach ($subjects as $sub) {
        $headers[] = $sub;
    }
    ;
    $fh = fopen("file.csv", "w");
    fputcsv($fh, $headers, ',', '\\', '"');

    try {
        foreach ($scores as $fields) {
            fputcsv($fh, $fields, ',', '\\', '"');
        }
    } catch (Exception $e) {
    }
    fclose($fh);
}

//assigns the values of csv to session
function import_from_csv(){
    if(isset($_FILES)){
        $tmpFilePath = $_FILES["csvFile"]['tmp_name'];

        $score = array();   
        $i=1;
        
        $handle = fopen($tmpFilePath,'r');
    
        $subjectsArray= fgetcsv($handle,1000,",","\"","\\");
        while(($data = fgetcsv($handle,1000,",","\"","\\"))){
            $score[] = $data;
            $i++;
        }   

        $_SESSION['subjectsArray']= $subjectsArray;
        $_SESSION['score']= $score;
    }
    
}

function createTable($subjectsArray,$scoreArray){
    $studentsCount = count($scoreArray);
    $subjectsCount = count($subjectsArray);

echo "<table border='1'><tr>";for($i=0;$i<1;$i++){
    for($j=0;$j<$subjectsCount;$j++){
            echo"<th colspan='1'>".$subjectsArray[$j]."</th>";
        }
        echo"</tr>";
    };

echo"<tbody>";for($i=1;$i<$studentsCount;$i++){
echo"<tr>";for($j=0;$j<$subjectsCount;$j++){
                    echo"<td>".$scoreArray[$i][$j]."</td>";
                }
echo"</tr>";
}
echo"</tbody></table>";
}

?>
