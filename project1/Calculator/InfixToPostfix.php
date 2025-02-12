<?php
global $val;
class InfixToPostfix{
    public $infix=[];
    public $poststack=[];
    public $opstack=[];
    public $limit;
    public $mathematicalFunction = FALSE;
    
    public function __construct($str){
        $str = str_replace('sin','s',$str);
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
        if($ch == '/' || $ch == '*' || $ch == '+' || $ch == '-' || $ch='^' || $ch='%'){
            return 1;
        }  
        else{
            return 0;
     }
    }

    public function infixTokenizer($str){//differentiate number other than single digit is a single whole number or not
        $tokens=[];
        $num = "";

        for($i=0;$i<strlen($str);$i++){
            $ch = $str[$i];
            if(ctype_space($ch)){// if space
                continue;
            }

            if(ctype_digit($ch)||$ch=='.'){// if is digit or decimal
                $num .= $ch;
            }else{
                if(!empty($num)){// if is neither digit nor decimal
                    $tokens[] = $num;
                    $num = '';
                }
                $tokens[] = $ch;
            }
        }
        if(!empty($num)) $tokens[]= $num;
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
                    if(InfixToPostfix::precedence( end($this->opstack))<InfixToPostfix::precedence($this->infix[$i])){//top of stack has < prcedence
                        array_push($this->opstack,$this->infix[$i]);
                    }
                    else{
                        if(!empty($this->opstack)){
                        while(InfixToPostfix::precedence(end($this->opstack)) >= InfixToPostfix::precedence($this->infix[$i])){
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

