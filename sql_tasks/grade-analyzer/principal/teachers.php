<?php require_once "../connection.php" ;
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT t.id,u.name,u.email FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id ");
$stmt->execute();
$allTeachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="../principal/requests.php"><p class='py-2 text-white'>Requests</p></a>



            </div>

            <div class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400/50 grid grid-flow-col grid-rows-3 text-center border border-black-500'>

                <div class='flex flex-row justify-center my-0 mx-0'>
                        <table >
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php 
                                        foreach ($allTeachers as $teacher) {
                                            echo "
                                                <tr>
                                                    <td>{$teacher['id']}</td>
                                                    <td>{$teacher['name']}</td>
                                                    <td>{$teacher['email']}</td>
                                                    <td>
                                                        <form method='POST' action='deleteData.php' onsubmit='return confirm(\"Are you sure you want to delete this student?\");'>
                                                            <input type='hidden' name='id' value='{$teacher['id']}'>
                                                            <input type='hidden' name='tableName' value={$_SERVER['REQUEST_URI']}>
                                                            <button type='submit' style='color: red; border: none; background: none; cursor: pointer;'>Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                    ?> 
                                </tr>
                                
                            </tbody>
                        </table>
                </div>

            </div>
                
        </div>
    </body>
    </html>

                    
    </div>
    </body>
    </html>

    <style>
        table,thead,thead,th,td {
            border: 1px solid rgb(120, 177, 204);
            border-collapse:collapse;
            border-spacing:15px;
        }

        th,td{
            padding: 5px 10px 5px 10px;
            
        }
        .addATeacher{
            flex-direction: row;
            flex-flow: end;
        }
    </style>