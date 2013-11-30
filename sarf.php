<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sarf
 * Idenify Arabic words
 * Idenify Arabic words varable 
 * Trasfer Arabic words between orignal and all tasreefat
 * @author mohamed
 */
class sarf {
    var $word ;
    var $count;
    var $plus = array();
    var $equi ;
    

    function setWord($go){
        $this->word = $go;
    }
    
    /**
     * function to determin number of character in the word
     */
    function countChar(){
    
        $this->word = trim($this->word);
        $count = mb_strlen($this->word, "UTF-8");
        return $count;    
    }
    function checkMarbota(){
        if (mb_substr($this->word, -1, 1, 'UTF-8') == "ة"){
            $this->plus["Marbota"] = mb_substr($this->word, -1, 1, 'UTF-8');
            $this->word = mb_substr($this->word, 0, -1, "UTF-8");
        }
    }
    function checkMany(){
        if (mb_substr($this->word, -2, 2, 'UTF-8') == "ين" || 
            mb_substr($this->word, -2, 2, 'UTF-8') == "ون" ||
            mb_substr($this->word, -2, 2, 'UTF-8') == "ات" ||
            mb_substr($this->word, -2, 2, 'UTF-8') == "ان" and $this->countChar() >4) {
                $this->plus["many"] = mb_substr($this->word, -2, 2, 'UTF-8');
                $this->word = mb_substr($this->word, 0, -2, "UTF-8");
        }  
    }
    function findA(){
        strpos($this->word, "ا");
    }
    function checkEl(){
        if (mb_substr($this->word,0 , 2, 'UTF-8') == "ال") {
            $this->plus['el'] = mb_substr($this->word, 0,2, 'UTF-8');
            $this->word = mb_substr($this->word, 2,null,"UTF-8");
        }
    }
    function checkKaf(){
        if($this->checkEl() == false && mb_substr($this->word,-1 , 1, 'UTF-8') == "ك"){
           $this->plus["kaf"] = mb_substr($this->word, -1, 1, 'UTF-8');
           $this->word = mb_substr($this->word, 0, -1, "UTF-8"); 
        }
    }
    function checkMem(){
        if (mb_substr($this->word,0 , 1, 'UTF-8') == "م") {
                $this->plus["mem"] = "م";
            }else {
            $this->plus["mem"] = false;
        }
    }
    
    function chechWaw(){
        if(mb_substr($this->word,-2 , 1, 'UTF-8')== "و"){
            $this->plus["waw"] = mb_substr($this->word, -2, 1, 'UTF-8');
        }  else {
            $this->plus["waw"] = false;
        }
    }
    
    function checkB(){
        
            if (mb_substr($this->word,0 , 1, 'UTF-8') == "ب") {
                $this->plus["gr"] = "ب";
                $this->word = mb_substr($this->word, 1,null,"UTF-8");
            
            
        }
    }
    function checkBase(){
        $this->checkMarbota();
        $this->checkEl();
        if ($this->countChar() > 3){
        $this->checkB();
        }
            $this->checkEl();

            $this->checkMany();
            $this->checkKaf();
        
        return $this->word;
    }
    
    function equi(){
        $this->checkBase();
        
        
        switch ($this->countChar()){
            case 4:
                switch ($this->findA()){
                    case 1:
                        $this->equi = "افعل";
                        break;
                    case 2:
                        $this->equi = "فاعل";
                        break;
                    case 3:
                        $this->equi = "فعال";
                        break;
                }
                $this->equi = "لا اعلم";
                break;
            
            case 5:
                $this->checkMem();
                $this->chechWaw();
                if ($this->plus['waw'] == "و" && $this->plus['mem'] = "م"){
                    $this->equi = "اسم مفعول";
                }else{
                    $this->equi = "لا اعلم";
                }
            break;
        }
        return $this->word;
    }
    
}
$word = new sarf();
$word->setWord('باحترام') ;
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<body>
    <?php 
    echo '</br>';  
    echo "اصل الكلمة :".$word-> equi();
    echo '</br>';  
    echo $word-> countChar();
    echo '</br>';
    if(isset($word->plus['gr'])){
        echo $word->plus['gr'] ." ". "اداة جر" ." ". $word-> checkBase() ." ". "اسم مجرور و علامة جرة الكسرة";
    }
    echo '</br>';
    if(isset($word->plus['el'])){
        echo $word->plus['el'] ." ". "اداة تعريف" ;
    }
    echo '</br>';
    echo $word -> equi;
    echo '</br>';
    var_dump($word->plus)
    ?>
</body>

