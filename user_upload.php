<?php

$shortopts ="u:p:h:";

$longopts = array(
    "file:",
    "create_table",
    "dry_run",
    "help",
);
$options = getopt($shortopts, $longopts);

//figure out what the directive was
if($options["u"] != false){
    //what comes next is the MySQL username
    $username = $options["u"];
}
elseif($options["p"] != false){
    //what comes next is the MySQL password
    $password = $options["p"];
}
elseif($options["h"] != false){
    //what comes next is the MySQL host
    $host = $options["h"];
}
elseif($options["file"] != false){
    $file = $options[file];
    openFile($file);
}
elseif($options["create_table"] != false){
    create();
}
elseif($options["dry_run"] != false){
    dryRun();
}
elseif($options["help"] != false){
    help();
}





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
    used with the --file directive in the instance that we want to run the
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