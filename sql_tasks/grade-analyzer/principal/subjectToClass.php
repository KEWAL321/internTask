<?php require_once "../connection.php" ;
$conn = Database::getConnection();
//Fetch data
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $stmt = $conn->prepare('SELECT class_name FROM classes WHERE id=:id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $class = $stmt->fetch(PDO::FETCH_ASSOC);
    //Fetch all listable subjects
    // $stmt = $conn->prepare('SELECT id,name FROM subjects');
    $stmt = $conn->prepare('SELECT subjects.id,subjects.name FROM subjects 
                                    WHERE subjects.id NOT IN (
                                    SELECT classes_subjects.subject_id 
                                    FROM classes_subjects 
                                    WHERE class_id = :id
                                    );');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($subjects);  

    $stmt = $conn->prepare('SELECT classes_subjects.class_id,classes_subjects.subject_id,subjects.name FROM classes_subjects INNER JOIN subjects ON classes_subjects.subject_id=subjects.id WHERE classes_subjects.class_id=:id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $classesSubjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($classesSubjects);   
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['subjectToClass'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO classes_subjects (class_id, subject_id) VALUES (:class_id, :subject_id)");
        $stmt->bindValue(":class_id", (int) $_GET['id'], PDO::PARAM_INT);
        $stmt->bindValue(":subject_id", (int) $_POST['subject_id'], PDO::PARAM_INT);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . urlencode($_GET['id']));
        exit(); 
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage()); 
    }   
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

        <div class='dashboard text-center w-[30%] h-[90%] py-10 rounded-l-[16px] border border-black-500'
            style="background-color:rgb(70,176,255)">

            <a href="../principal/dashboard.php">
                <p class='py-2 text-white'>Dashboard</p>
            </a>
            <a href="../principal/students.php">
                <p class='py-2 text-white'>Students</p>
            </a>
            <a href="../principal/teachers.php">
                <p class='py-2 text-white'>Teachers</p>
            </a>
            <a href="../principal/classes.php">
                <p class='py-2 text-white'>Classes</p>
            </a>
            <a href="../principal/subjects.php">
                <p class='py-2 text-white'>Subjects</p>
            </a>
            <a href="../principal/requests.php">
                <p class='py-2 text-white'>Requests</p>
            </a>

        </div>

        <div
            class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400/50 text-center border flex flex-col  items-center'>

            <!--form-->
            <form class="p-5 rounded-lg shadow-lg w-full max-w-md"
                action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?id='.$id)?>' method='post'>
                <?php if(!empty($subjects)){?>
                <label>Select a subject:</label><br>
                <select name="subject_id" class="w-full">
                    <?php
                                    foreach($subjects as $subject){
                                        echo '<option value="'.$subject['id'].'">'.$subject['name'].'</option>';
                                    }
                                ?>
                </select>
                <?php }else{ ?>
                <select name="subject_id" class="w-full" disabled>
                    <?php
                                        echo '<option value="NULL">None</option>';

                                ?>
                </select>
                <?php } ?>


                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 mt-2"
                    name='subjectToClass'>
                    Add
                </button>
                <hr>
            </form>

            <div class='flex flex-col items-center justify-center overflow-y-auto max-h-[400px] w-full'>
                <?php
                                if(!empty( $classesSubjects )){
                            echo '
                            <label for="name" class="block text-gray-600 font-medium mb-1">Subjects in class '.$class['class_name'].' :</label>

                                <table class="text-gray-900">
                                
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>';
                                ?>
                <?php 
                                            foreach ($classesSubjects as $class_subject) {
                                                echo "
                                                    <tr>
                                                        <td>{$class_subject['name']}</td>
                                                        <td>
                                                            <form method='POST' action='deleteData.php' onsubmit='return confirm(\"Are you sure you want to delete this student?\");'>
                                                                <input type='hidden' name='class_id' value='{$class_subject['class_id']}'>
                                                                <input type='hidden' name='subject_id' value='{$class_subject['subject_id']}'>
                                                                <input type='hidden' name='tableName' value={$_SERVER['REQUEST_URI']}>
                                                                <button type='submit' style='color: red; border: none; background: none; cursor: pointer;'>Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                ";
                                            }
                                        }
                                        ?>
                </table>
            </div>
        </div>
    </div>


</body>

</html>


<style>
table,
thead,
thead,
th,
td {
    border: 1px solid rgb(120, 177, 204);
    border-collapse: collapse;
    border-spacing: 15px;
}

th,
td {
    padding: 5px 10px 5px 10px;
}

#btns {
    height: 50px;
}
</style>