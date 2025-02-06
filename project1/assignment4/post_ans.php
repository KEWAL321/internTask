<?php

class postfix_to_result{
    public $resultstack=[];
    public $poststack=[];
    public $result;
    
    public function __construct($arr){
        $this->poststack=$arr;
       $this->result = $this->postfixToResult();
        $this->return_result();
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
                }
            }
        }
    
        return array_pop($stack);
    }

    public function return_result(){
        echo '<h2>'.$this->result.'<h2><br>';
    }

}


$postfix=array('3','2','*','15','5','/','+','7','2','*','-','2','3','*','+');
$postfix = new postfix_to_result($postfix);





