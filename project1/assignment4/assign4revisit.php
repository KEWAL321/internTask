<?php

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
        $this->return_result();
    }
    public static function precedence($ch){

        $precedenceMap = [
            '^' => 3,
            '/'=> 2,'*'=>2,
            '+'=>1,'-'=>1
        ];
        return $precedenceMap[$ch]??0;
    }


    public function push($item){
    array_push($this->opstack, $item);
    }

    public function pop(){
        return array_pop($this->opstack);
    }
    public function top(){//returns last element of the stack
        return end($this->opstack);

    }
    public function is_empty(){
        return empty($this->opstack);
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
                // $num = $num.$ch;
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
                echo '<h2>'.$this->infix[$i].' pushed to opstack echo1<h2><br>'; //      ECHO 1
                
            }
            else if($this->infix[$i]==')'){
                if($this->infix[$i]!='('){// pops out operator between ( and )
                    echo '<h2>'.end($this->opstack).' pushed to poststack echo2<h2><br>'; //      ECHO 2
                    array_push($this->poststack,end($this->opstack));
                    $popped = array_pop( $this->opstack );
                    echo '<h2>'.$popped.' popped out</h2><br>';
                }
                array_pop($this->opstack);
            }
            else 
            if(!$this->isOperator($this->infix[$i])){
                array_push($this->poststack,$this->infix[$i]);
                echo '<h2>'.$this->infix[$i].' is not opeator and pushed to poststack echo 3<h2> '; //   ECHO 3
                
            }
            else {
                if(empty($this->opstack)){
                array_push($this->opstack,$this->infix[$i]);
                echo '<h2>'.$this->infix[$i].' pushed to opstack echo 4<h2> '; //   ECHO 4
                }
                else if(end($this->opstack )== '('){
                    array_push($this->opstack,$this->infix[$i]);
                }
                else{
                    echo '<h2>'.$this->infix[$i].' is opeator<h2>';
                    if(infix_to_postfix::precedence( end($this->opstack))<infix_to_postfix::precedence($this->infix[$i])){//top of stack has < prcedence
                        array_push($this->opstack,$this->infix[$i]);
                        echo '<h2>'.infix_to_postfix::precedence( end($this->opstack)).'<'.infix_to_postfix::precedence($this->infix[$i]).'<h2>';
                        echo '<h2>'.end($this->opstack).'vs'.$this->infix[$i].'<h2>';
                    }
                    else{
                        if(!empty($this->opstack)){
                        while(infix_to_postfix::precedence(end($this->opstack)) >= infix_to_postfix::precedence($this->infix[$i])){
                            echo '<h2>'.infix_to_postfix::precedence( end($this->opstack)).'>'.infix_to_postfix::precedence($this->infix[$i]).'<h2>';
                            echo '<h2>'.end($this->opstack).'vs'.$this->infix[$i].'<h2>';
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

    public function return_result(){
        echo '<h2>postfix</h2><br>';
        foreach($this->poststack as $key=>$value){
            print_r($value);
        }
        print_r($this->poststack);
}
}

if(isset($_GET) && !empty($_GET['name'])){
    $infix = $_GET['name'];
echo "<h1>".$infix."<h1>";
$postfix = new infix_to_postfix($infix);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/assignment4/post_ans.php" method="POST">
        <input type="text" placeholder="Enter the infix here" name="name" id="">
        <button type="submit">Submit</button>
    </form>
</body>
</html>


