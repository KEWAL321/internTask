<!-- ### **Mini Project 2: Password Strength Checker**
Create a program that checks the strength of a password based on the following rules:
1. At least 8 characters long.
2. Contains at least one uppercase letter.
3. Contains at least one lowercase letter.
4. Contains at least one digit.
5. Contains at least one special character (e.g., `!`, `@`, `#`, `$`, etc.).
The program should rate the password as "Weak," "Moderate," or "Strong" and inform the user which rules their password failed. -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div id="form" class="mt-5" class="form-control">
    <form action="/assignment2.php" method="GET">
        <div id="div2">
        <label for="password" class="form-label">Enter Your Password: </label>
        <input type="text" name="password" id="password" id="password" class="form-control" value="<?php echo isset($_GET["password"])?$_GET["password"]:'' ;?>"><br>
        <button type="submit">Submit</button>
        </div>
    </form>
</div>
</body>
</html>

<?php 
function checkChars($str) { 
    $upperCase = preg_match('/[A-Z]/', $str); 
    $lowerCase = preg_match('/[a-z]/', $str); 
    $specialChar = preg_match('/[^A-Za-z0-9]/', $str); 
    $numericVal = preg_match('/[0-9]/', $str); 
    $length = strlen($str)>=8? 1:0;
    $total = $upperCase+$lowerCase+$specialChar+$numericVal+$length;

    return [ 
        'Uppercase' => $upperCase, 
        'Lowercase' => $lowerCase, 
        'Special Characters' => $specialChar, 
        'Numeric Values' => $numericVal, 
        'Strength' => $total,
        '8 Character Length' => $length
    ]; 
} 


if(!empty($_GET)){ 
$str = $_GET["password"];
$result = checkChars($str); 

if($result["Strength"] <3){
    echo "Weak Password <br>";
}elseif($result["Strength"] <=4){
    echo "Moderate Password <br>";
}else{
    echo "Strong Password <br>";
}

foreach ($result as $type => $hasType) { 
    !$hasType &&  print("missing $type<br>") ; 
//   echo  !$hasType &&  "missing $type \n" ; // this doesnt work , prints 1 if the condition satisfies
    
} 
}

?>