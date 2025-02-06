<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/assignment4.php" method="GET">
        <input type="number" name="" id=""><br>

        <button>(</button>
        <button>)</button>
        <button>%</button>
        <button>AC</button><br>

        <button>7</button>
        <button>8</button>
        <button>9</button>
        <button>/</button><br>

        <button>4</button>
        <button>5</button>
        <button>6</button>
        <button>*</button><br>

        <button>1</button>
        <button>2</button>
        <button>3</button>
        <button>-</button><br>

        <button>0</button>
        <button>.</button>
        <button>=</button>
        <button>+</button><br>
    </form>
</body>
</html>

<?php
function multiply($a, $b) {
return $a * $b;
}

function divide($a, $b) {
    return $a / $b;
}

function exponent($a) {
return exp($a);
}

function square($a) {
return $a * $a;
}

function pow($a, $b) {
return pow($a, $b);
}

function trigonometric($a, $b) {
    
}

function trigonometric_inv($a, $b) {}

function cube($a) {
    return $a*$a*$a;
}

function eurler_e(){
return exp(1);
}

function pi(){
return pi();
}

function log($a,$b){
return log($a,$b);
}

function cube_root($a) {
    return pow($a,1/3);
}
function square_root($a) {
    sqrt($a);
}

function power_root($a) {}

if(isset($_GET) && $_SERVER["REQUEST_METHOD"]=="GET"){

}
?>