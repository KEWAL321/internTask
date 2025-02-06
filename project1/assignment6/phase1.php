<?php session_start() ?>
<html lang="en">

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
                        elseif(!empty($_SESSION['marks'])){
                            $students = $_SESSION['marks'];
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
                        elseif(!empty($_SESSION['subjects'])){
                            $subjects = $_SESSION['subjects'];
                            echo count($subjects);
                        }
                        else{
                            echo "";
                       };?>"class="form-control" required><br>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>

        <form action="/assignment6/phase1.php" class="container mt-5" method="POST" enctype="multipart/form-data">
        <label for="inputCsv">Choose a csv file: </label><br>
        <input type="file" id="inputCsv" name="csvFile" accept=".csv"  required>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
    </div>



    <?php   
    include 'helper.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['students']) && !isset($_GET['subjects'])) {
        if (session_status() === PHP_SESSION_ACTIVE){
            session_unset();
            // initializationForm();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['students']) && !isset($_POST['subjectsArray'])) {
        $numOfStd = $_GET['students'];
        $numOfSub = $_GET['subjects'];
        // initializationForm();
        showSubForm($numOfSub, $numOfStd);

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
        import_from_csv();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['students']) && !isset($_POST['subjectsArray'])) {
        $numOfStd = $_GET['students'];
        $numOfSub = $_GET['subjects'];

        if(isset($_POST['subjectsArray'])){
            $_SESSION["subjectsArray"]= $_POST['subjectsArray']; 
            // initializationForm();
            showSubForm($numOfSub, $numOfStd);
            showMainForm($numOfStd, $numOfSub, $_POST['subjectsArray']);
        }
        
        if(isset($_POST['score'])){
            $_SESSION['score']= $_POST['score'];
            
            $subjectsArray = $_POST['subjectNEXT'];
            if(is_string($subjectsArray)){
                $subjectsArray = json_decode($subjectsArray, true);
            }
            // initializationForm();
            showSubForm($numOfSub, $numOfStd);
            showMainForm($numOfStd, $numOfSub, $_SESSION["subjectsArray"], $_POST['score']);
            
            displayExportBtn();            
        }
        
        
        if (isset($_POST['exportToCsv'])){
            // initializationForm();
            showSubForm($numOfSub, $numOfStd);
            showMainForm($numOfStd, $numOfSub, $_SESSION['subjectsArray'],$_SESSION['score']);  
            export_to_csv($_SESSION['subjectsArray'],$_SESSION['score']);
            displayExportBtn();

        }   
    }
    ?>

    <?php 
    // if(!empty($_SESSION['subjects'])&&!empty($_SESSION['marks'])){

    // }


    

    ?>
    <!-- elseif(!empty($_SESSION['subjects'])&&!empty($_SESSION['marks'])){} -->
</body>

</html>