<?php

$shortopts ="u:p:h:";
$longopts = array(
    "file:",
    "create_table",
    "dry_run",
    "help",
);
$options = getopt($shortopts, $longopts);

//figure out what the directive was... 
if(array_key_exists("u", $options)){
    //what comes next is the MySQL username
    $username = $options["u"];

}
if(array_key_exists("p", $options)){
    //what comes next is the MySQL password
    $password = $options["p"];
 
}
if(array_key_exists("h", $options)){
    //what comes next is the MySQL host
    $host = $options["h"];
}
if(array_key_exists("file", $options)){
    $file = $options["file"];
}
if(array_key_exists("create_table", $options)){
    if($file != false){
        create();
    }
}
if(array_key_exists("dry_run", $options)){
    if($file != false){
        dryRun();
    }
}

if(array_key_exists("help", $options)){
    help();
}






function openFile($file){
    //when input is --file followed by the argument
        if (($myfile = fopen($file, "r")) !== false) {
            
            fclose($myfile);
        }else {
            print ("File unable to be opened.");
        }

}

function dryRun(){
    //when --dry_run is inputted
}

function create(){
    //when --create_table is inputted

}

function help(){
    //when --help is inputted
    print("Commands \n
    --file [csv file name] \n
    Gives the name of the file to be parsed \n
    \n 
    --create_table\n
    This will cause the MySQL users table to be built\n 
    \n
    --dry_run\n
    Used with the --file directive in the instance that we want to run the
    script but not insert into the DB. All other functions will be executed, but the database won't
    be altered.\n
    \n
    -u \nMySQL username\n
    \n
    -p \nMySQL password\n
    \n
    -h \nMySQL host\n
    \n
    --help\n
    This is what you are seeing.\n
    ");
}

?>