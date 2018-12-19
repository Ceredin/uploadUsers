<?php

$host = "localhost"; //default host if not specified.
$username = "user"; //default username
$password = "password"; //default password
$db_name = "users"; 

$conn = mysqli_connect("$host", "$username", "$password", "$db_name") or die ("Not able to connect!");
mysqli_select_db("$db_name");

$isDryRun = true; //default is dryRun

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
        $isDryRun = false; //no longer dryRun
        create();
    }else{
        
    }
}
if(array_key_exists("dry_run", $options)){
    if(isset($file) && $file != false){
        dryRun($file);
    }
}

if(array_key_exists("help", $options)){
    help();
}






function dryRun($file){
    //opens csv file takes all the content and puts them into a variable and validates it
        if (($myfile = fopen($file, "r")) !== false) {
            
            $row = 1;
            $rowcontent = "";
            //put all of the contents in csv file into one array
            while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                if (($row-1) == 1){
                    //print "row 1!! \n \n";
                    continue;
                }
                for ($col=0; $col < $num; $col++) {
                    //this is where the validation happens!!
                    if($col < 2){
                        //so this is either a first or last name
                        $name = strtolower($data[$col]);
                        $rowcontent .= trim(ucfirst($name));
                        //print $rowcontent . " ";
                    }else{
                        //this should be the email which is the unique key
                        //assumption: MySQL table will handle multiple identical entries of email
                        $email = strtolower($data[$col]); //lowercased now
                        
                        $emailcount = count_chars($email,1);
                        //print_r($emailcount);
                        if(array_key_exists('64',$emailcount)){
                            //firstly @ has to exist to be valid email... 64 is the ascii for @
                            if($emailcount[64] == 1 ){
                                $rowcontent .= " " . $email;
                            }else{
                                $rowcontent = "";
                            }
                        }else{
                            //this is not a valid email without @
                            $rowcontent = "";
                            print "Invalid Email Address! \n";
                        }
                    }
                }
                //print $rowcontent . "\n";
                //figure out if this is dry run only or not.
                //if not, then send this data to be written to DB
                $rowcontent = "";
            }

            fclose($myfile);
        }else {
            print "File unable to be opened.";
        }
}


function create(){
    //when --create_table is inputted

    $sql = "CREATE TABLE Users(
        fname VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        mail VARCHAR(50) PRIMARY KEY
        )";

    if ($conn->query($sql) === true){
        print "Table of users created. \n";
    }else{
        print "Not able to create table. \n";
    }

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

$conn->close();
?>