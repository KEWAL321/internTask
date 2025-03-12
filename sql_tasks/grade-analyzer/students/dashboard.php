<?php
session_start();
require_once "../connection.php";
$conn = Database::getConnection();

if($_SESSION['id']){

    $stmt = $conn->prepare('SELECT s.id,s.phone,s.address,u.name,u.email,c.class_name FROM students AS s INNER JOIN users AS u ON s.user_id=u.id LEFT JOIN classes AS c ON s.class_id = c.id WHERE s.user_id = :id');
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    // var_dump($result);
}
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

        <div class='dashboard text-center w-[30%] h-[90%] py-10 rounded-l-[16px] flex flex-col justify-between'
            style="background-color:rgb(70,176,255)">
            <div>
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

            <div>
                <a href="../login-page.php">
                    <p class='py-2 text-white'>Log out</p>
                </a>
            </div>

        </div>

        <div
            class='h-[90%] w-[50%] py-10 pl-10 rounded-r-[16px] bg-gray-400/50 grid grid-flow-col grid-rows-3 text-center'>

            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Name</p><br>
                <p><?php echo $result['name']?? 'Not Set';?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Attendence</p><br>
                <p><?php echo 'Not Set';    ?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Mail</p><br>
                <p><?php echo $result['email']??'Not Set'; ?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Phone</p><br>
                <p><?php echo $result['phone']??'Not set'?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Address</p><br>
                <p><?php echo $result['address']??'Not set'?></p>
            </div>
            <div class='w-[250px] h-[150px]' style="border:1px solid rgb(70,176,255)">
                <p style="border:1px solid rgb(70,176,255)">Grade</p><br>
                <p><?php echo $result['class_name']??'Not set'?></p>
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