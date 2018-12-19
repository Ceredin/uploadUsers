<?php

$shortopts ="uph";

$longopts = array(
    "file:",
    "create_table",
    "dry_run",
    "help",
);
$options = getopt($shortopts, $longopts);

//do some stuff

var_dump($options);



function openFile($file){
    //when input is --file followed by the argument
        if (($myfile = fopen($file, "r")) !== FALSE) {
            




            fclose($myfile);
        }else {
            print ("File unable to be opened.");
        }

}

function create(){
    //when --create_table is inputted

}

function dryRun(){
    //when --dry_run is inputted
}


?>