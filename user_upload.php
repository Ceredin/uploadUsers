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
    if(isset($file) && $file != false){
        openFile($file);
    }else{
        
    }
}
if(array_key_exists("dry_run", $options)){
    if(isset($file) && $file != false){
        dryRun();
    }
}

if(array_key_exists("help", $options)){
    help();
}






function openFile($file){
    //opens csv file takes all the content and puts them into a variable and validates it
        if (($myfile = fopen($file, "r")) !== false) {
            
            $row = 1;
            //put all of the contents in csv file into one array
            while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "$num fields in line $row: \n";
                $row++;
                for ($col=0; $col < $num; $col++) {
                    //echo $data[$col] . "\n";
                    //this is where the validation happens!!
                    if($col < 2){
                        //so this is either a first or last name
                        $name = strtolower($data[$col]);
                        print(ucfirst($name) . " ");
                    }else{
                        //this should be the email which is the unique key
                        $email = strtolower($data[$col]);
                        

                    }
                }
            }

            fclose($myfile);
        }else {
            print "File unable to be opened.";
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