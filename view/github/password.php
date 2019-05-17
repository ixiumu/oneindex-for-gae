<?php
if(isset($_SERVER['HTTP_AUTHORIZATION'])){
    
}
header('WWW-Authenticate:Basic');
header("HTTP/1.0 401 Unauthorized");