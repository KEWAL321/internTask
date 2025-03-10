<?php
    // session_start(); 
    require_once "./connection.php";

    $conn = Database::getConnection();

// Check connection
if (!$conn) {
    die("Connection failed: "); 
    }

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['submit1'])) {

        try{
            // Prepare the SQL statement (Corrected: no single quotes around column names)
            $sql = $conn->prepare("INSERT INTO users (name, role, password, email) VALUES (:name, :role, :password, :email)");
            
            // Bind parameters (Corrected the parameter types: 'i' for integer, 's' for string)
            $sql->bindValue(':name',$_POST['name']);    
            $sql->bindValue(':role',$_POST['role']);
            $sql->bindValue(':password',$_POST['password']);
            $sql->bindValue(':email',$_POST['email']);

            // $sql->bindValue(':spassword', password_hash($_POST['spassword'], PASSWORD_BCRYPT)); // Hash password

            // Execute the query
            if (!$sql->execute()) {
                echo "Error: " . $sql->errorInfo()[2];
            }
        }catch(Exception $e){
            echo "Inerstion Error: " . $sql->errorInfo()[2];
        }


        try{
            //finds user_id from email
            // $user_email = $_POST['email'];
            // echo $user_email;
            $stmt = $conn->prepare("SELECT id FROM users WHERE email=:email");
            $stmt->bindValue(':email',$_POST['email']);
            $stmt->execute();
            $user_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
        }catch(Exception $e){
            echo "user_id from  user email not found <br>";
        }

        try{
            //inserting user_id fk value from user table to students table
            $role = $_POST['role'];
            $role .= 's';
            switch ($role) {
                case 'students':
                    $stmt = $conn->prepare("INSERT INTO $role (phone, address, class_id, user_id) VALUES (NULL,NULL,NULL,:user_id)");
                    break;

                case 'teachers':
                    $stmt = $conn->prepare("INSERT INTO $role (user_id) VALUES (:user_id)");
                    break;
            }
            $stmt->bindValue(':user_id',$user_id);
            $stmt->execute();
        }catch(Exception $e){
            echo $e;
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
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='name' required>
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="mail" class="block text-gray-600 font-medium mb-1">Mail:</label>
            <input type="email" id="mail" placeholder="Enter your mail address"
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='email' required>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-gray-600 font-medium mb-1">Password:</label>
            <input type="text" id="password" placeholder="Enter your password" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='password' required>
        </div>

        <!-- Role Field -->
        <div class="mb-4">
            <label for="role" class="block text-gray-600 font-medium mb-1">Role:</label>
            <select name="role" class="block text-gray-600 w-full">
                <option value="teacher">teacher</option>
                <option value="student">student</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" name='submit1'>
            Register
        </button>

        <hr>
        <div>
            <!-- <a href="./login-page.php" class="w-full block text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300"> -->
            <a href="./login-page.php" class="text-center text-gray-700 hover:text-blue-600 font-bold py-2 px-4 transition duration-300">
                <p>
                    Already registered!
                </p>
            </a>
        </div>

    </form>
</body>
</html>
