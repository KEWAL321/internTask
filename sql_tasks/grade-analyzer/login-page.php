<?php
// require('./db_conn.php');

$host = 'db'; 
$username = 'root';
$password = 'password';
$database = 'crud';
$u_exist = true;
$p_exist = true;

$conn = new mysqli($host,$username,$password,$database);
// $conn = dbConn();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit2'])) {
        // Prepare the SQL statement (Corrected: no single quotes around column names)
        $sql = $conn->prepare("SELECT password from student WHERE sname=?");
        
        // Bind parameters (Corrected the parameter types: 'i' for integer, 's' for string)
        $sql->bind_param("s",$_POST['sname']);
        // Execute the query
        if (!$sql->execute()) {
            echo "Error: " . $sql->error;
        }
        else{
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            if($row){
                $password = $row['password'];
                if($_POST['spassword']==$password){
                    header("Location: main.php");
                }
                else{
                    $p_exist=false;
                }
            }else{
                $u_exist=false;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="flex justify-center items-center h-screen bg-gray-100">
    <form class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post'>
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login!</h2>

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-600 font-medium mb-1">Name:</label>
            <input type="text" id="name" placeholder="Enter your name" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='sname' required>
            <?php if(!$u_exist){echo "<p style=color:red;>username doesn't exists</p>";}?>
        </div>
        
        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-gray-600 font-medium mb-1">Password:</label>
            <input type="text" id="password" placeholder="Enter your password" 
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='spassword' required>
            <?php if(!$p_exist){echo "<p style=color:red;>password doesn't match</p>";}?>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" name='submit2'>
            Login
        </button>
    </form>
</body>
</html>
