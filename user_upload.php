<?php

if (($myfile = fopen("users.csv", "r")) !== FALSE) {
    //a less dramatic way of handling the error than die()


    

    fclose($myfile);
}else {
    print ("File unable to be opened.");
}



?>