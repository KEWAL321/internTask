<?php
global $val;
class infix_to_postfix{
    public $infix=[];
    public $poststack=[];
    public $opstack=[];
    public $limit;
    
    public function __construct($str){
        $this->limit = strlen( $str );
        $this->infix = $this->infixTokenizer($str);
        $this->postfixConversion();
        $this->lastoperation();
    }
    public static function precedence($ch){

        $precedenceMap = [
            '^' => 3,
            '/'=> 2,'*'=>2, '%'=>2,
            '+'=>1,'-'=>1
        ];
        return $precedenceMap[$ch]??0;
    }

    public function isOperator($ch){
        if($ch == '/' || $ch == '*' || $ch == '+' || $ch == '-'){
            return 1;
        }  
        else{
            return 0;
     }
    }

    public function infixTokenizer($str){
        $tokens=[];
        $num = "";

        for($i=0;$i<strlen($str);$i++){
            $ch = $str[$i];
            if(ctype_space($ch)){
                continue;
            }

            if(ctype_digit($ch)||$ch=='.'){
                $num .= $ch;
            }else{
                if(!empty($num)){
                    $tokens[] = $num;
                    $num = '';
                }
                $tokens[] = $ch;
            }
        }
        if(!empty($num)) $tokens[]= $num;;
        return $tokens;

    }
    public function postfixConversion(){
        for($i=0;$i<sizeof($this->infix);$i++){
            if($this->infix[$i]== '('){
                array_push($this->opstack, $this->infix[$i]);
                
            }
            else if($this->infix[$i]==')'){
                if($this->infix[$i]!='('){// pops out operator between ( and )
                    array_push($this->poststack,end($this->opstack));
                    $popped = array_pop( $this->opstack );
                }
                array_pop($this->opstack);
            }
            else 
            if(!$this->isOperator($this->infix[$i])){
                array_push($this->poststack,$this->infix[$i]);
                
            }
            else {
                if(empty($this->opstack)){
                array_push($this->opstack,$this->infix[$i]);
                }
                else if(end($this->opstack )== '('){
                    array_push($this->opstack,$this->infix[$i]);
                }
                else{
                    if(infix_to_postfix::precedence( end($this->opstack))<infix_to_postfix::precedence($this->infix[$i])){//top of stack has < prcedence
                        array_push($this->opstack,$this->infix[$i]);
                    }
                    else{
                        if(!empty($this->opstack)){
                        while(infix_to_postfix::precedence(end($this->opstack)) >= infix_to_postfix::precedence($this->infix[$i])){
                            array_push($this->poststack,$this->opstack[count($this->opstack)-1]);
                            array_pop($this->opstack);
                        }
                    array_push($this->opstack,$this->infix[$i]);
                    }
                }

                }
            }
        }
    }
    public function lastoperation(){
    while(!empty($this->opstack)){
        array_push($this->poststack,end($this->opstack));
        array_pop($this->opstack);
    }
    }

}
?>

<?php

class postfix_to_result extends infix_to_postfix{
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
    $postcalc1 = new postfix_to_result($infix); 
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
    <form action="/assignment4/assign4_1.php" method="GET" id="form">
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
