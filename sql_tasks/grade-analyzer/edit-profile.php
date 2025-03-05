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
        <!-- <div class='main flex w-[95%] h-[92%] bg-gray-400 justify-left rounded-[20px]'> -->
        <div class='flex flex-row rounded-[20px] h-[100%] w-[100%] justify-center items-center'>

            <div class='dashboard text-center w-[30%] h-[90%] py-10 rounded-l-[16px] border border-black-500' style="background-color:rgb(70,176,255)"> 

                <a href="./dashboard.php"><p class='py-2 text-white'>Dashboard</p></a>
                <a href="./marksheet.php"><p class='py-2 text-white'>Marksheet</p></a>
                <a href="./edit-profile.php"><p class='py-2 text-white'>Edit Profile</p></a>

            </div>

            <div class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400/50 grid grid-flow-col grid-rows-3 text-center border border-black-500'>

                <form class="p-8 rounded-lg shadow-lg w-full h-full" action='./marksheet.php' method='post'>
                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-600 font-medium mb-1">Name:</label>
                        <input type="text" id="name" placeholder="Enter your name" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='name' required>
                    </div>
                    
                    <!-- Address Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-600 font-medium mb-1">Address:</label>
                        <input type="text" id="password" placeholder="Enter your address" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='address' required>
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-600 font-medium mb-1">Phone:</label>
                        <input type="text" id="password" placeholder="Enter your phone" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name='phone' required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" name='submit3'>
                        Save
                    </button>
                </form>
            </div>
                
        </div>
    </body>
    </html>