<?php
global $val;
class InfixToPostfix{
    public $infix=[];
    public $poststack=[];
    public $opstack=[];
    public $limit;
    
    public function __construct($str){
        $str = str_replace('sin','s',$str);
        $str = str_replace('cos','c',$str);
        $str = str_replace('tan','t',$str);
        $str = str_replace('log','l',$str);
        $this->limit = strlen( $str ); 
        $this->infix = $this->infixTokenizer($str);   
        $this->postfixConversion();
        $this->lastoperation();
    }

    public static function precedence($ch){
        $precedenceMap = [
            '^' => 3,'√'=>3,
            '/'=> 2,'*'=>2, '%'=>2,
            '+'=>1,'-'=>1,'s'=>1,'l'=>1,'c'=>1,'t'=>1
        ];
        return $precedenceMap[$ch]??0;
    }

    public function isOperator($ch){
        if($ch == '/' || $ch == '*' || $ch == '+' || $ch == '-' || $ch == 's' || $ch == 'c' || $ch == 't' || $ch == 'l' || $ch == '√' || $ch == '%'){
            return 1;
        }  
        else{
            return 0;
     }
    }

    public function infixTokenizer($str){
        $tokens=[];
        $num = "";

        for ($i = 0; $i < mb_strlen($str, 'UTF-8'); $i++) {
            $ch = mb_substr($str, $i, 1, 'UTF-8'); // Extract one character at a time
    
            if (ctype_space($ch)) {
                continue;
            }
    
            if (ctype_digit($ch) || $ch == '.') { // If the character is a digit or decimal
                $num .= $ch;
            } else {
                if (!empty($num)) { // If the character is neither digit nor decimal
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
        for($i=0;$i<count($this->infix);$i++){
            if($this->infix[$i]== '('){
                array_push($this->opstack, $this->infix[$i]);
                
            }
            else if($this->infix[$i]==')'){
                if($this->infix[$i]!='('){// pops out operator between ( and )
                    if(end($this->opstack)!='('){
                        array_push($this->poststack,end($this->opstack));
                        
                        array_pop( $this->opstack );
                    }
                }
                array_pop($this->opstack);
            } 
            else if(!$this->isOperator($this->infix[$i])){//if current element is not operator
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
