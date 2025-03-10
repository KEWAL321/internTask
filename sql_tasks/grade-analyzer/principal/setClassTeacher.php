<?php require_once "../connection.php" ;
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT id,class_name FROM classes");
$stmt->execute();
$allclasses = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $stmt = $conn->prepare("SELECT * FROM teachers");
$stmt = $conn->prepare("SELECT t.id,u.name FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id ");
$stmt->execute();
$allteachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($allteachers);  
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Document</title>
    </head>
    <body>
        <div class='flex flex-row rounded-[20px] h-[100%] w-[100%] justify-center items-center'>

            <div class='dashboard text-center w-[30%] h-[90%] py-10 rounded-l-[16px] border border-black-500' style="background-color:rgb(70,176,255)"> 

                <a href="../principal/dashboard.php"><p class='py-2 text-white'>Dashboard</p></a>
                <a href="../principal/students.php"><p class='py-2 text-white'>Students</p></a>
                <a href="../principal/teachers.php"><p class='py-2 text-white'>Teachers</p></a>
                <a href="../principal/classes.php"><p class='py-2 text-white'>Classes</p></a>
                <a href="../principal/subjects.php"><p class='py-2 text-white'>Subjects</p></a>
                <a href="../principal/requests.php"><p class='py-2 text-white'>Requests</p></a>

            </div>

            <div class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400/50 text-center border flex flex-row justify-center'>

                <form class=" p-8 rounded-lg shadow-lg w-full max-w-md" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post'>

                    <!-- Name Field -->
                    <div class="mb-4">
                    <label for="role" class="block text-gray-600 font-medium mb-1">Class Name:</label>
                        <?php
                        echo "<select name='class_id' class='block text-gray-600 w-full'>";
                            foreach ($allclasses as $class) {
                                echo '
                                        <option value="'.$class['id'].'">'.$class['class_name'].'</option>
                                        ';
                                    }
                                    echo '</select>';
                        ?>
                    </div>

                    <!-- teacher names Field -->
                    <div class="mb-4">
                        <label for="role" class="block text-gray-600 font-medium mb-1">Teachers:</label>

                        <?php
                        // $stmt = $conn->prepare("SELECT t.id,u.name FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id ");
                        // $stmt->execute();
                        // $allTeachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        // // print_r($allTeachers);
    
                        echo "<select name='teacher_id' class='block text-gray-600 w-full'>
                        <option value='NULL'>Not Set</option>";
                        foreach ($allteachers as $teacher) {
                            // var_dump($teacher);
                            echo '
                                    <option value="'.$teacher['id'].'">'.$teacher['name'].'</option>
                                    ';
                                }
                                echo '</select>';
                        ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" name='setclassteacher'>
                        Add
                    </button>

                    <hr>
                </form>

            </div>
                        
        </div>
    </body>
    </html>

    <?php 
        if($_SERVER["REQUEST_METHOD"] == 'POST' && isset( $_POST['setclassteacher'] )) {
            $stmt = $conn->prepare("UPDATE classes SET teacher_id=:teacher_id WHERE id=:class_id");
            $stmt->bindParam(":class_id", $_POST["class_id"]);
            $stmt->bindParam(":teacher_id", $_POST["teacher_id"]);
            $stmt->execute();
            header("Location: ./classes.php");
            // print_r($_POST);
        }   
    ?>
    <style>
        table,thead,thead,th,td {
            border: 1px solid rgb(120, 177, 204);
            border-collapse:collapse;
            border-spacing:15px;
        }

        th,td{
            padding: 5px 10px 5px 10px;            
        }
        #btns{
            height: 50px;
        }
    </style>