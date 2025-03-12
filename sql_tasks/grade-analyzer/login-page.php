<?php
require_once "./connection.php";
$conn = Database::getConnection();

session_start();


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit2'])) {
        $stmt = $conn->prepare("SELECT id,name,email,role,password from users WHERE users.email=:email");
        
        $stmt->bindValue(":email",$_POST['email']);
        // Execute the query
        if (!$stmt->execute()) {
            echo "Error: ";
        }
        else{
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if($result){

                $password = $_POST['password'];
                if($_POST['password']==$result['password'] && $_POST['role'] == $result['role']){ 

                    $path =  ($_POST['role']=='principal')?$_POST['role']:$_POST['role'] . 's';
                    $_SESSION['id'] = $result['id'];

                    header("Location:".$path.'/dashboard.php');
                }else{
                    echo "<script>
                            alert('Invalid credentials. Please try again.');
                        </script>";
                }
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
    <form class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md"
        action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post'>
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login!</h2>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-gray-600 font-medium mb-1">Email:</label>
            <input type="text" id="email" placeholder="Enter your Email"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                name='email' required>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-gray-600 font-medium mb-1">Password:</label>
            <input type="text" id="password" placeholder="Enter your password"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                name='password' required>
        </div>

        <!-- Role Field -->
        <div class="mb-4">
            <label for="role" class="block text-gray-600 font-medium mb-1">Role:</label>
            <select name="role" class="block text-gray-600 w-full">
                <option value="principal">principal</option>
                <option value="class teacher">class teacher</option>
                <option value="teacher">teacher</option>
                <option value="student">student</option>
            </select>
        </div>
        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300"
            name='submit2'>
            Login
        </button>
    </form>
</body>

</html>