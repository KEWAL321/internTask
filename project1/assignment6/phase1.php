<?php 
session_start();
include './helper.php';
?>
<html lang="en">

<?php

if(isset($_POST['csvImport'])){
    if(isset($_FILES['csvFile'])){
        import_from_csv();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['students']) && !isset($_GET['subjects']) && isset($_FILES)) {
    if (session_status() === PHP_SESSION_ACTIVE){
        session_unset();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="phase1.css">
    <title>Document</title>
</head>

<body>
    <div id="form" class="container mt-5">
        <form action="/assignment6/phase1.php" method="GET">
            <h1 class="top_h1">Enter number of </h1>
            <label for="students" class="form-label">
                <h1>Students: </h1>
            </label>

            <input type="number" name="students" id="students"
                value="<?php 
                    if(isset($_GET["students"])){
                        echo $_GET["students"];
                        }
                        elseif(!empty($_SESSION['score'])){
                            $students = $_SESSION['score'];
                            echo count($students);
                        }
                        else{
                            echo "";
                      };?>"class="form-control" required><br>

            <label for="subjects" class="form-label">
                <h1>Subjects: </h1>
            </label>
            <input type="number" name="subjects" id="subjects"
                value="<?php 
                    if(isset($_GET["subjects"])){
                            echo $_GET["subjects"];
                        }
                        elseif(!empty($_SESSION['subjectsArray'])){
                            $subjects = $_SESSION['subjectsArray'];
                            echo count($subjects);
                        }
                        else{
                            echo "";
                       };?>"class="form-control" required><br>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>

        <!-- form for csv input -->
        <form action="/assignment6/phase1.php" class="container mt-5" method="POST" enctype="multipart/form-data">
        <label for="inputCsv">Choose a csv file: </label><br>
        <input type="file" name="csvFile" accept=".csv" id="inputCsv" required>
        <button type="submit" name="csvImport" class="btn btn-primary mt-4">Submit</button>
        </form>
    </div>



    <?php   
//do this if the request method is GET and students is set and subjectsArray is not
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['students']) && !isset($_POST['subjectsArray'])) {
        $numOfStd = $_GET['students'];
        $numOfSub = $_GET['subjects'];
        showSubForm($numOfSub, $numOfStd);

    }
//do this if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

         if(isset($_GET['students']) && isset($_POST['subjectsArray'])) {
            $numOfStd = $_GET['students'];
            $numOfSub = $_GET['subjects'];

            // displays the main form after subects and students name are provided
        if(isset($_POST['subjectsArray']) && isset($_POST['studentsNameArray'])){
            $_SESSION["subjectsArray"]= $_POST['subjectsArray'];
            $_SESSION["studentsNameArray"]= $_POST['studentsNameArray'];
            showSubForm($numOfSub, $numOfStd);
            showMainForm($numOfStd, $numOfSub,$_POST['subjectsArray'],$_SESSION['studentsNameArray']);
        }
            
    }
    //after main Form is submitted 
    if(isset($_POST['score']) && isset($_GET['students']) && isset($_GET['subjects'])){ 

        $numOfStd = $_GET['students'];
        $numOfSub = $_GET['subjects'];

        $_SESSION['score']= $_POST['score'];
        $subjectsArray = $_POST['subjectNEXT'];

        if(is_string($subjectsArray)){
            $subjectsArray = json_decode($subjectsArray, true);
        }

        showSubForm($numOfSub, $numOfStd);
        showMainForm($numOfStd, $numOfSub, $_SESSION["subjectsArray"],$_SESSION["studentsNameArray"], $_POST['score']);
        export_to_csv($_SESSION['subjectsArray'],$_SESSION["studentsNameArray"],$_SESSION['score']);

    }

}
    // operation if the csv file is given as input
    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['subjectsArray'])&&!empty($_SESSION['score'])){
        $studentsNameArray = $_SESSION['studentsNameArray'];
        $subjectsArray=$_SESSION["subjectsArray"];
        $scoreArray=$_SESSION["score"];
        $totalSubjects = count($_SESSION["subjectsArray"]);
        $totalStudents = count($_SESSION["score"]);
        showSubFormSession($totalSubjects,$totalStudents,$subjectsArray,$studentsNameArray,$scoreArray);
        if(!empty($_POST['stdName'])){
            generateMarksheet($_POST['stdName']);
        }
    }
    ?>
</body>

</html>