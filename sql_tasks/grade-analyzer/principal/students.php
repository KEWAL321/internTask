<?php require_once "../connection.php" 
$conn = Database::getConnection();
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

            <div class='dashboard text-center w-[30%] h-[90%] py-10 rounded-l-[16px] border border-black-500' style="background-color:rgb(70,176,255)"> 

                <a href="../principal/dashboard.php"><p class='py-2 text-white'>Dashboard</p></a>
                <a href="../principal/students.php"><p class='py-2 text-white'>Students</p></a>
                <a href="../principal/teachers.php"><p class='py-2 text-white'>Teachers</p></a>
                <a href="../principal/classes.php"><p class='py-2 text-white'>Classes</p></a>
                <a href="../principal/subjects.php"><p class='py-2 text-white'>Subjects</p></a>


            </div>

            <div class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400/50 grid grid-flow-col grid-rows-3 text-center border border-black-500'>

                <div class='border border-black-500'>
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                            $sql = $conn->prepare("SELECT * FROM students ");
                            $stmt->execute();
                            $students = $stmt->fetch(PDO::FETCH_ASSOC); 
                            echo $students;
                            ?>
        
                            <tr></tr>
                        </tbody>
                    </table>
                </div>

            </div>
                
        </div>
    </body>
    </html>