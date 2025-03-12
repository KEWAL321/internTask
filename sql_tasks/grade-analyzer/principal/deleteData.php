<?php require_once "../connection.php" ;
$conn = Database::getConnection();
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tableName'])) {

    //assigns the previous file uri
    $path = $_POST['tableName'];

    //parse pure url
    $parsed_url = parse_url($path);
    $path = $parsed_url['path'];

    // Check if the query part exists
    if (isset($parsed_url['query'])) {
        $queryString = '?' . $parsed_url['query'];
    }

    //extracts table_name
    $fileName = basename(pathinfo(parse_url($path, PHP_URL_PATH), PATHINFO_BASENAME),".php");
    
    // delete for students and teachers
    if($fileName == 'students' || $fileName == 'teachers') {
        $stmt = $conn->prepare("DELETE from users WHERE id = (SELECT user_id from $fileName WHERE id = :id)");
        $stmt->bindValue(':id',$_POST['id']);   
    }
    else if($fileName == 'classes_subjects'){//delete for classes_subjects
        $stmt = $conn->prepare("DELETE FROM $fileName WHERE $fileName.class_id = :class_id AND $fileName.subject_id = :subject_id");
        $stmt->bindValue(':class_id',$_POST['class_id']);   
        $stmt->bindValue(':subject_id',$_POST['subject_id']);   
    }
    else{//delete for classes and subjects
        $stmt = $conn->prepare("DELETE FROM $fileName WHERE $fileName.id = :id");
        $stmt->bindValue(':id',$_POST['id']);   
    }

    
    if ($stmt->execute()) {
        if($queryString){
            echo "<script>window.location.href='$fileName.php$queryString';</script>";
        }else{
            echo "<script>window.location.href='$fileName.php';</script>";
        }
    } else {
        if($queryString){
            echo "<script>window.location.href='$fileName.php$queryString';</script>";
        }else{
            echo "<script>window.location.href='$fileName.php';</script>";
        }
    }
    
}
?>