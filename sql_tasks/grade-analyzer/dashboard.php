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

            <div class='dashboard text-center bg-violet-950 w-[30%] h-[90%] py-10 rounded-l-[16px] border border-black-500'> 

                <a href="./dashboard.php"><p class='py-2 text-white'>Dashboard</p></a>
                <a href=""><p class='py-2 text-white'>Marksheet</p></a>
                <a href="./edit-profile.php"><p class='py-2 text-white'>Edit Profile</p></a>

            </div>

            <div class='h-[90%] w-[50%] py-10 rounded-r-[16px] bg-gray-400 grid grid-flow-col grid-rows-3 text-center border border-black-500'>

                <div class='border border-black-500'><p class='attendence'>Attendence</p></div>
                <div><p class='attendence'>Attendence</p></div>
                <div><p class='mail'>Mail</p></div>

                <div><p class='phone'>Phone</p></div>
                <div><p class='address'>Address</p></div>

                <div>
                    <p class='grade'>Grade</p>
                </div>
            </div>
                
        </div>
    </body>
    </html>