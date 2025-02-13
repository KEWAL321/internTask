<?php

include './InfixToPostfix.php';

class PostfixToResult extends InfixToPostfix{
    public $resultstack=[];
    public $result;
    
    public function __construct($str){
        parent::__construct($str);
       $this->result = $this->postfixToResult();
    }

    public function postfixToResult(){   

        $stack = [];

        foreach ($this->poststack as $key=>$value) {
            if (is_numeric($value)) {
                $stack[] = $value;
            }else if($value == 's'){
                $a = array_pop($stack);
                $stack[] = sin(deg2rad($a));
            }else if($value == 'c'){
                $a = array_pop($stack);
                $stack[] = cos(deg2rad($a));
            }else if($value == 't'){
                $a = array_pop($stack);
                $stack[] = tan(deg2rad($a));
            }else if($value == 'c'){
                $a = array_pop($stack);
                $stack[] = log($a);
            } 
            else {
                $b = array_pop($stack);
                $a = array_pop($stack);
                switch ($value) {
                    case '+': $stack[] = $a + $b; break;
                    case '-': $stack[] = $a - $b; break;
                    case '*': $stack[] = $a * $b; break;
                    case '/': $stack[] = $a / $b; break;
                    case '%': $stack[] = $a % $b; break;
                    case '^': $stack[] = pow($a,$b); break;
                }
            }
        }
    
        return array_pop($stack);
    }

}

if(isset($_GET) && !empty($_GET['name'])){
    $infix = $_GET['name'];
    $postcalc1 = new PostfixToResult($infix);   
    $val = $postcalc1->result;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Calculator</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div id="form_div" class="bg-white p-6 rounded-lg shadow-lg">
        <div><h2 class="text-xl font-semibold text-center mb-4"><?php echo $val; ?></h2></div>

        <form action="/Calculator/PostfixToResult.php" method="GET" id="form" class="space-y-4">
            <div class="input_div">
                <p id="hidden_P"></p>
                <input type="text" name="name" id="input_element" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
            </div>
            
            <div id="btns" class="grid grid-cols-4 gap-2">
                <span class="btn bg-gray-200 p-2 rounded" onclick='func("(")'>(</span>
                <span class="btn bg-gray-200 p-2 rounded" onclick='func(")")'>&nbsp)</span>
                <span class="btn bg-gray-200 p-2 rounded" onclick='func("^")'>^</span>
                <span class="btn bg-red-400 text-white p-2 rounded" onclick='func("AC")'>AC</span>

                <span class="btn bg-gray-300 p-2 rounded" onclick='func(7)'>7</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(8)'>8</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(9)'>9</span>
                <span class="btn bg-blue-500 text-white p-2 rounded" onclick='func("X")'>X</span>

                <span class="btn bg-gray-300 p-2 rounded" onclick='func(4)'>4</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(5)'>5</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(6)'>6</span>
                <span class="btn bg-blue-500 text-white p-2 rounded" onclick='func("/")'>/</span>

                <span class="btn bg-gray-300 p-2 rounded" onclick='func(1)'>1</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(2)'>2</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(3)'>3</span>
                <span class="btn bg-blue-500 text-white p-2 rounded" onclick='func("*")'>*</span>
                
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(0)'>0</span>
                <span class="btn bg-gray-300 p-2 rounded" onclick='func(".")'>.</span>
                <span class="btn bg-blue-500 text-white p-2 rounded" onclick='func("-")'>-</span>    
                <span class="btn bg-blue-500 text-white p-2 rounded" onclick='func("+")'>+</span>
                
                <span class="btn bg-green-500 text-white p-2 rounded" onclick='func("sin")'>sin</span>
                <span class="btn bg-green-500 text-white p-2 rounded" onclick='func("cos")'>cos</span>
                <span class="btn bg-green-500 text-white p-2 rounded" onclick='func("√")'>√</span>    
                <span class="btn bg-green-500 text-white p-2 rounded" onclick='func("%")'>%</span>

                <span class="btn bg-green-500 text-white p-2 rounded" onclick='func("log")'>log</span>    
                <span class="btn bg-green-500 text-white p-2 rounded" onclick='func("tan")'>tan</span>    
                <button class="btn bg-blue-700 text-white p-2 rounded" type="submit">=</button>
            </div>
        </form> 
    </div>

    <script>
        const inp_value = document.getElementById("input_element");
        function func(a){
            let inp = inp_value.value;
            switch(a){
                case "AC":
                    inp_value.value = "";
                    break;

                case "X":{
                     inp_value.value = inp.substring(0,inp.length-1);
                    break;
                }
                default:{
                console.log(a);
                inp_value.value += a;
                }
            }
        }
    </script>
</body>
</html>

