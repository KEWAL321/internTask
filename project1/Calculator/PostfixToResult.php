<?php

include './InfixToPostfix.php';

class PostfixToResult extends InfixToPostfix{
    public $resultstack=[];
    public $result;
    
    public function __construct($str){
        parent::__construct($str);
       $this->result = $this->postfixToResult();
    }

    public function isOperator($ch){
        if($ch == '/' || $ch == '*' || $ch == '+' || $ch == '-'){
            return 1;
        }  
        else{
            return 0;
     }
    }

    public function postfixToResult(){    

        $stack = [];

        foreach ($this->poststack as $token) {
            if (is_numeric($token)) {
                $stack[] = $token;
            } else {
                $b = array_pop($stack);
                $a = array_pop($stack);
                switch ($token) {
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body><div id="form_div">
    <div><h2><?php echo $val; ?></h2></div>

    <form action="/Calculator/PostfixToResult.php" method="GET" id="form">

        <div id="operator_div">
        <input type="text" placeholder="Enter the infix here" name="name" id="input_element" class="form-control"><br>
        </div>
        
        <div id="operator_div">
        <span class="btn" onclick='func("(")'>(</span>
        <span class="btn" onclick='func(")")'>&nbsp)</span>
        <span class="btn" onclick='func("^")'>^</span>
        <span class="btn" onclick='func("AC")'>AC</span><br>
        </div>

        <div id="operator_div">
        <span class="btn" onclick='func(7)'>7</span>
        <span class="btn" onclick='func(8)'>8</span>
        <span class="btn" onclick='func(9)'>9</span>
        <span class="btn" onclick='func("%")'>%</span><br>
        </div>

        <div id="operator_div">
        <span class="btn" onclick='func(4)'>4</span>
        <span class="btn" onclick='func(5)'>5</span>
        <span class="btn" onclick='func(6)'>6</span>
        <span class="btn" onclick='func("/")'>/</span><br>
        </div>

        <div id="operator_div">
        <span class="btn" onclick='func(1)'>1</span>
        <span class="btn" onclick='func(2)'>2</span>
        <span class="btn" onclick='func(3)'>3</span>
        <span class="btn" onclick='func("*")'>*</span><br>
    </div>
    
    <div id="operator_div"> 
        <span class="btn" onclick='func(0)'>0</span>
        <span class="btn" onclick='func(".")'>.</span>
        <span class="btn" onclick='func("-")'>-</span>    
        <span class="btn" onclick='func("+")'>+</span><br>
    </div>

    
    <div id="operator_div">
        <span class="btn" onclick='func("X")'>X</span>    
        <button class="btn" type="submit">=</button>
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
    <style>
        body{
            height: 100vh;
            display: flex;
            justify-content: center;
        }

        #operator_div{
            margin-top: 10px;
        }

        .btn {
            border: 1px solid black;
            width: 45px;
            margin-right: 5px;
        }

        .btn:hover{
            background-color: black;
            color: white;
        }

        #input_element {
            width: 100%;
            background-color: rgba(1, 1, 1, 0.2);
        }
        
    </style>
</body>
</html>     


