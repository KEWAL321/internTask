<?php
// require('./db_conn.php');

$host = 'db'; 
$username = 'root';
$password = 'password';
$database = 'crud';
$u_exists = false;
$p_exists = false;

$conn =  new mysqli($host,$username,$password,$database);
// $conn =  dbConn();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit1'])) {
        // Prepare the SQL statement (Corrected: no single quotes around column names)
        $sql = $conn->prepare("INSERT INTO student (sname, parent_mail, password) VALUES (?, ?, ?)");
        
        // Bind parameters (Corrected the parameter types: 'i' for integer, 's' for string)
        $sql->bind_param("sss",$_POST['sname'], $_POST['semail'], $_POST['spassword']);

        // Execute the query
        if (!$sql->execute()) {
            echo "Error: " . $sql->error;
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
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Register</h2>

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-600 font-medium mb-1">Name:</label>
            <input type="text" id="name" placeholder="Enter your name" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='sname' required>
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="mail" class="block text-gray-600 font-medium mb-1">Mail:</label>
            <input type="email" id="mail" placeholder="Enter your parent's email"
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='semail' required>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-gray-600 font-medium mb-1">Password:</label>
            <input type="text" id="password" placeholder="Enter your password" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='spassword' required>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" name='submit1'>
            Register
        </button>

        <hr>
        <div class="mt-2">
            <a href="./login-page.php" class="w-full block text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Already registered!
            </a>
        </div>

    </form>
</body>
</html>
