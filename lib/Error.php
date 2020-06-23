<?php
function errorHandler($errno, $errstr, $errfile, $errline){
        header("Code: 500");
        echo $errstr, 'in file ', $errfile, 'line number to', $errline;
        return true;
}
