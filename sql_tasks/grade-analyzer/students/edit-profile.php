<?php
session_start();
require_once "../connection.php";
$conn = Database::getConnection();

if($_SESSION['id']){
    $stmt = $conn->prepare("SELECT id,class_name FROM classes");

    $stmt->execute();
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT id from students where user_id=:id");
    $stmt->bindValue(":id",$_SESSION['id']);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
}

if($_SERVER["REQUEST_METHOD"] == 'POST' && isset( $_POST['submit'] )) {

    $stmt = $conn->prepare("UPDATE students SET phone=:phone,address=:address,class_id=:class_id WHERE id=:id");
    $stmt->bindValue(":phone",$_POST['phone']);
    $stmt->bindValue(":address",$_POST['address']);
    $stmt->bindValue(":class_id", $_POST['class_id'] ?? NULL);

    $stmt->bindValue(":id",$student['id']);
    $stmt->execute();
    header("Location: ./dashboard.php");
    exit();
}   
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
    <style>
    /* Tailwind + Custom CSS to remove input spinners */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
    </style>
</head>

<body>
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

        <div class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400/50 text-center'>

            <form class="p-8 rounded-lg w-full h-full" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>'
                method='post'>

                <!-- Address Field -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-600 font-medium mb-1">Address:</label>
                    <input type="text" id="address" placeholder="Enter your address"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        name='address' required>
                </div>

                <!-- Phone Field -->
                <div class="mb-4">
                    <label for="phone" class="block text-gray-600 font-medium mb-1">Phone:</label>
                    <input type="text" id="phone" placeholder="Enter your phone"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        name='phone' required>
                </div>

                <!-- Class Field -->
                <div class="mb-4">
                    <label for="class" class="block text-gray-600 font-medium mb-1">Class:</label>
                    <select name="class_id" id="class" class="w-full">

                        <option>None</option>
                        <?php
                        foreach($classes as $class){
                            echo '
                            <option value='.$class['id'].'>'.$class['class_name'].'</option>
                            ';
                        }
                        ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300"
                    name='submit'>
                    Save
                </button>
            </form>
        </div>

    </div>
</body>

</html>