<?php

namespace Test;



/**
 * ls -la 
 * drwxr-xr-x   4 a123456  staff  128  9 14 13:48 Test
 * -rw-r--r--   1 a123456  staff  820  9 14 13:43 README.en.md
 * -rw-r--r--   1 a123456  staff  909  9 14 13:43 README.md
 * 
 * 代码执行
 * php ./Test/HelloWord.php 
 * 
 * 
 */



class HelloWord
{
    public function echoHelloWord()
    {
        $msg = 'hello word php';
        return $msg;
    }
}

$obj = new HelloWord();

$data = $obj->echoHelloWord();

var_dump($data);

