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
    <form action='./main.php?students=$numOfStd&subjects=$numOfSub' method='POST'>";

    echo "<input hidden name='subjectNEXT' value= " . json_encode($subjectsArray) . "> ";// to keep values even after submitting
    for ($i = 0; $i < $numOfStd; $i++) {
        echo '<h2>Scores of ' . $studentsNameArray[$i] . '</h2>';
        for ($j = 0; $j < $numOfSub; $j++) 
        {
            $scoreValue = isset($scores[$i][$j]) ? $scores[$i][$j] : '';
            echo "<div class='mt-5'><input type='number' name='score[$i][$j]' style='width:200px' max='100' min='1' step='0.5' class='form-control' placeholder='Enter $subjectsArray[$j] score' value='" . (isset($_SESSION['score'])?$_SESSION['score'][$i][$j]:'') . "' required> <hr></div>";
        }
    }
    echo '<button type="submit" class="btn btn-primary">Export To Csv</button></form></div>';

}

function showSubForm($numOfSub, $numOfStd, $subjects = [])
{
    echo '<div id="form_subjects_students" class="container mt-5">';
    echo "<form action='./main.php?students=$numOfStd&subjects=$numOfSub' method='POST'>";
    echo '<h2>Enter students Name: </h2>';

    for ($i = 0; $i < $numOfStd; $i++) {
        echo "<div class='mt-5'><input type='text' name='studentsNameArray[]' class='form-control' placeholder='Student ".($i+1)."' value='" . (isset($_SESSION['studentsNameArray'])?$_SESSION['studentsNameArray'][$i]:'') . "' required>";
        isset($_SESSION['studentsNameArray']);
    }

    echo '<br><br>';

    echo '<h2>Enter subjects Name: </h2>';

    for ($i = 0; $i < $numOfSub; $i++) {
    
        echo "<div class='mt-5'><input type='text' name='subjectsArray[]' id='subject' class='form-control' placeholder='Subject ".($i+1)."' value='" . (isset($_SESSION['subjectsArray'])?$_SESSION['subjectsArray'][$i]:'') . "' required>";
        isset($_SESSION['subjectsArray']);
    }

    echo "<button type='submit' style='margin-top:30px;' class='btn btn-primary'>Submit</button></form></div>";
}


function showMainFormSession($totalSubjects,$totalStudents,$subjectsArray,$studentsNameArray,$marksArray){
    echo "<div id='form_students' class='container mt-5'>
    <form action='./main.php' method='POST'>";

    for ($i = 0; $i < $totalStudents; $i++) {
        echo '<h2>Scores of ' . $studentsNameArray[$i] . '</h2>';
        for ($j = 0; $j < $totalSubjects; $j++) 
        {
            $scoreValue = isset($marksArray[$i][$j]) ? $marksArray[$i][$j] : '';
            echo "<div class='mt-5'><input type='number' name='score[$i][$j]' style'width:200px' max='100' min='1' step='0.5' class='form-control' placeholder='Enter $subjectsArray[$j] score' value=" . (isset($_SESSION['score'])?$_SESSION['score'][$i][$j]:'') . " required> <hr></div>";
        }
    }
    echo '<button type="submit" name="mainFormButton" class="btn btn-primary">Submit</button></form></div>';

    //shows table when main form submit button is clicked
    if(isset($_POST['score'])&& !empty($_SESSION['subjectsArray'])&&!empty($_SESSION['score'])){
        if(isset($_POST["mainFormButton"])){
            $subjectsArray = $_SESSION["subjectsArray"];
            $scoreArray = $_SESSION["score"];
            createTable($subjectsArray,$studentsNameArray,$scoreArray);
        }
    }

    echo "<div style='margin-top:30px;' ><form action='./phase1.php' method='POST'>
        <input type='text' name='stdName' placeholder='Enter student valid name to generate marksheet' id='generateInput' value='".(isset($_SESSION['stdName'])?$_SESSION['stdName']:''). "' required>
        <button type='submit' id='generate' class='btn btn-primary'>Generate</button>
        </form></div>";
}

function showSubFormSession($totalSubjects,$totalStudents,$subjectsArray,$studentsNameArray,$marksArray)
{
    echo '<div id="form_subjects_students" class="container mt-5">';
    echo "<form action='./main.php' method='POST'>";
    echo '<h2>Enter students Name: </h2>';

    for ($i = 0; $i < $totalStudents; $i++) {
        echo "<div class='mt-5'><input type='text' name='studentsNameArray[]' class='form-control' placeholder='Student ".($i+1)."' value='" . (isset($_SESSION['studentsNameArray'][$i])?$_SESSION['studentsNameArray'][$i]:'') . "' required>";
        isset($_SESSION['studentsNameArray']);
    }

    echo '<br><br>';

    echo '<h2>Enter subjects Name: </h2>';

    for ($i = 0; $i < $totalSubjects; $i++) {
    
        echo "<div class='mt-5'><input type='text' name='subjectsArray[]' class='form-control' placeholder='Subject ".($i+1)."' value='" . (isset($_SESSION['subjectsArray'])?$_SESSION['subjectsArray'][$i]:'') . "' required>";
        isset($_SESSION['subjectsArray']);
    }

    echo '<button type="submit" class="btn btn-primary">Submit</button></form></div>';

    showMainFormSession($totalSubjects,$totalStudents,$subjectsArray,$studentsNameArray,$marksArray);
    
}

function export_to_csv($subjectsArray,$studentsNameArray,$scoresArray)//no of students,subjects and scores are required
{   
    $headers=[];
    $i=0;
    
    $headers[] = "Students";
    foreach ($subjectsArray as $sub) {
        $headers[] = $sub;
    }
    ;
    $fh = fopen("file.csv", "w");
    fputcsv($fh, $headers, ',', '\\', '"');
    
    try {
        foreach ($scoresArray as $fields) {
            array_unshift($fields,$studentsNameArray[$i]);            
            fputcsv($fh, $fields, ',', '\\', '"');
            $i++;
        }
    } catch (Exception $e) {
    }
    fclose($fh);
}

//assigns the values of csv to session
function import_from_csv(){
    if(isset($_FILES)){
        $tmpFilePath = $_FILES["csvFile"]['tmp_name'];
        $headers = [];
        $studentsNameArray=[];
        $score = array();   
        $i=1;
        
        $handle = fopen($tmpFilePath,'r');
        $headers= fgetcsv($handle,1000,",","\"","\\");  
        $subjectsArray= array_slice($headers,1,count($headers));

        while(($data = fgetcsv($handle,1000,",","\"","\\"))){
            $studentsNameArray[]=array_splice($data,0,1)[0];
            $score[] = $data;
        } 

        $_SESSION['headers'] = $headers;
        $_SESSION['studentsNameArray'] =  $studentsNameArray;
        $_SESSION['subjectsArray']= $subjectsArray;
        $_SESSION['score']= $score;
    }
    
}

function createTable($subjectsArray,$studentsNameArray,$scoreArray){
    $studentsCount = count($scoreArray);
    $subjectsCount = count($subjectsArray);

echo "<table border='1'><tr>";for($i=0;$i<1;$i++){
    echo"<th colspan='1'>Students</th>";
    for($j=0;$j<$subjectsCount;$j++){
            echo"<th colspan='1'>".$subjectsArray[$j]."</th>";
        }
        echo"</tr>";
    };

echo"<tbody>";for($i=0;$i<$studentsCount;$i++){
    echo"<tr><td>".$studentsNameArray[$i]."</td>";for($j=0;$j<$subjectsCount;$j++){
                    echo"<td>".$scoreArray[$i][$j]."</td>";
                }
echo"</tr>";
}
echo"</tbody></table>";
}

function generateMarksheet($stdName){
    $subCount = count($_SESSION['subjectsArray']);

    $key =  array_search($stdName,$_SESSION['studentsNameArray']);

    $html = "<table border='1'><tr><th>Subjects</th><th>Total Marks</th><th>Marks Obtained</th></tr>";

    $html .= "<tbody>";
    for ($i = 0; $i < $subCount; $i++) {
    $html .= "<tr><td>" . $_SESSION['subjectsArray'][$i] . "</td>";
    $html .= "<td>100</td>";
    $html .= "<td>" . $_SESSION['score'][$key][$i] . "</td></tr>";
    }

    $totalMarks = $subCount * 100;
    $obtainedMarks = array_sum($_SESSION['score'][$key]);
    $percentage = ($obtainedMarks / $totalMarks) * 100;

    $html .= "<tr><td>Total: </td><td>$totalMarks</td><td>$obtainedMarks</td></tr>";
    $html .= "<tr><td>Percentage: </td><td colspan='2'>$percentage%</td></tr>";

    $html .= "</tbody></table>";

    echo $html; 
     $_SESSION['marksheet'] = $html; 


    echo "<form action='' method='POST' style=' margin-top: 20px;' >
    <input type='hidden' name='marksheetOwner' value='$stdName'>
    <input type='email' placeholder='send email to' name='email' id='sendEmailInput' value='".(isset($_POST['email'])?$_POST['email']:'')."' required>
    <button type='submit' id='sendEmailButton' class='btn btn-primary'>Send</button></form>";
}
?>
