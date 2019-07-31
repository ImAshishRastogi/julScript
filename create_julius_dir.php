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


// download necessary files

// julius/bin directory files

echo "Downloading bin tools...".PHP_EOL;
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/mkdfa.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/fixfulllist.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/mkclscript.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/mktrihed.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/prompts2mlf.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/prompts2wlist.jl");
shell_exec("mv mkdfa.jl julius/bin/");
shell_exec("mv fixfulllist.jl julius/bin/");
shell_exec("mv mkclscript.jl julius/bin/");
shell_exec("mv mktrihed.jl julius/bin/");
shell_exec("mv prompts2mlf.jl julius/bin/");
shell_exec("mv prompts2wlist.jl julius/bin/");
echo "Downloaded and moved to julius/bin/".PHP_EOL;

// julius/lexicon directory file

echo "Downloading lexicon tools...".PHP_EOL;
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/lexicon/VoxForgeDict.txt");
shell_exec("mv VoxForgeDict.txt julius/lexicon/");
echo "Downloaded and moved to julius/lexicon/".PHP_EOL;

//julius/model directory files

echo "Downloading model tools...".PHP_EOL;
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/global.ded");
shell_exec("wget -c https://github.com/VoxForge/develop/raw/master/tutorial/mkphones0.led");
shell_exec("wget -c https://github.com/VoxForge/develop/raw/master/tutorial/mkphones1.led");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/codetrain.scp");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/wav_config");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/hmm0/proto");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/train.scp");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/config");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sil.hed");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/mktri.led");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/maketriphones.ded");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/tree1.hed");
shell_exec("wget -c https://github.com/ImAshishRastogi/julScript/blob/master/app.php");
shell_exec("wget -c https://github.com/ImAshishRastogi/julScript/blob/master/INSTRUCTION.md");

shell_exec("mv global.ded julius/model/");
shell_exec("mv mkphones0.led julius/model/");
shell_exec("mv mkphones1.led julius/model/");
shell_exec("mv codetrain.scp julius/model/");
shell_exec("mv wav_config julius/model/");
shell_exec("mv proto julius/model/");
shell_exec("mv train.scp julius/model/");
shell_exec("mv config julius/model/");
shell_exec("mv sil.hed julius/model/");
shell_exec("mv mktri.led julius/model/");
shell_exec("mv maketriphones.ded julius/model/");
shell_exec("mv tree1.hed julius/model/");
shell_exec("mv app.php julius/model/");
shell_exec("mv INSTRUCTION.md julius/model/");
echo "Downloaded and moved to julius/model/".PHP_EOL;



echo "Downloading sample.conf".PHP_EOL;
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sample.jconf");
shell_exec("mv sample.jconf julius/model/");
echo "Downloaded and moved to julius/model/".PHP_EOL;


echo "All required tools are downloaded and moved to corresponding directories successfully!!".PHP_EOL;
echo "NOW READ INSTRUCTION.md in julius/model/ directory"



//
?>
