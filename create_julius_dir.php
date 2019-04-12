<?php

//create directories
shell_exec("mkdir julius");
shell_exec("mkdir julius/model");
shell_exec("mkdir julius/bin");
shell_exec("mkdir julius/train");
shell_exec("mkdir julius/lexicon");
shell_exec("mkdir julius/train/wav");
shell_exec("mkdir julius/train/mfcc");

for($i=0;$i<=15;$i++){
    shell_exec("mkdir julius/model/hmm".$i);
}

echo "Directories successfully created."."\n";

shell_exec("mv INSTRUCTION julius/model/");
shell_exec("mv download_tools.php julius/model/");
shell_exec("mv app.php julius/model/");

echo "scripts are moved to julius/model/ directry"."\n";
echo "Read INSTRUCTION in julius/model/ to proceed further"."\n";

//
?>
