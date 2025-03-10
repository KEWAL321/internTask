<?php require_once "../connection.php" ;
$conn = Database::getConnection();
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tableName'])) {
    $path = $_POST['tableName'];
    $fileName = basename($path,".php");

    if($fileName == 'students' || $fileName == 'teachers') {
        $stmt = $conn->prepare("DELETE from users WHERE id = (SELECT user_id from $fileName WHERE id = :id)");
    }
    else {
        $stmt = $conn->prepare("DELETE FROM $fileName WHERE $fileName.id = :id");
    }

    $stmt->bindValue(':id',$_POST['id']);   
    
    if ($stmt->execute()) {
        echo "<script>window.location.href='$fileName.php';</script>";
    } else {
        echo "<script>window.location.href='$fileName.php';</script>";
    }
    
    // $id = intval($_POST['id']); 
} else {
    echo "<script>alert('Invalid request!'); window.location.href='$fileName.php';</script>";
}
?>
