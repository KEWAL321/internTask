<?php
session_start();
require_once "../connection.php";
$conn = Database::getConnection();

if($_SESSION['id']){
    $stmt = $conn->prepare("SELECT * FROM students INNER JOIN users ON students.user_id=users.id WHERE students.user_id=:id");
    $stmt->bindValue(":id", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    print_r($result);
}
// if(isset($result)){
//     $stmt = $conn->prepare("SELECT * FROM students WHERE user_id=:user_id");
//     $stmt->bindValue(":user_id", $results['id']);
//     $stmt->execute();
//     $studentResult = $stmt->fetchAll(PDO::FETCH_ASSOC); 
// }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body>
    <!-- <div class='main flex w-[95%] h-[92%] bg-gray-400 justify-left rounded-[20px]'> -->
    <div class='flex flex-row rounded-[20px] h-[100%] w-[100%] justify-center items-center'>

        <div class='dashboard text-center w-[30%] h-[90%] py-10 rounded-l-[16px]'
            style="background-color:rgb(70,176,255)">

            <a href="./dashboard.php">
                <p class='py-2 text-white'>Dashboard</p>
            </a>
            <a href="./marksheet.php">
                <p class='py-2 text-white'>Marksheet</p>
            </a>
            <a href="./edit-profile.php">
                <p class='py-2 text-white'>Edit Profile</p>
            </a>

        </div>

        <div
            class='h-[90%] w-[50%] py-10 pl-10 rounded-r-[16px] bg-gray-400/50 grid grid-flow-col grid-rows-3 text-center'>

            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Name</p><br>
                <p><?php echo $results['name'];?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Attendence</p><br>
                <p><?php echo 'not set';    ?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Mail</p><br>
                <p><?php echo $results['email']; ?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Phone</p><br>
                <p><?php echo 9761660123; ?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Address</p><br>
                <p><?php echo 'Kathmandu, Maitidevi'; ?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Grade</p><br>
                <p><?php echo 12; ?></p>
            </div>

        </div>

    </div>
</body>

</html>

<style>
.card {
    width: 50%;
}
</style>