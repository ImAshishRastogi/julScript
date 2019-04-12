<?php


// download necessary files

// julius/bin directory files

shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/mkdfa.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/fixfulllist.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/mkclscript.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/mktrihed.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/prompts2mlf.jl");
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/bin/prompts2wlist.jl");
shell_exec("mv mkdfa.jl ../bin/");
shell_exec("mv fixfulllist.jl ../bin/");
shell_exec("mv mkclscript.jl ../bin/");
shell_exec("mv mktrihed.jl ../bin/");
shell_exec("mv prompts2mlf.jl ../bin/");
shell_exec("mv prompts2wlist.jl ../bin/");


// julius/lexicon directory file
/*
shell_exec("wget -c https://github.com/VoxForge/develop/blob/master/lexicon/VoxForgeDict.txt");
shell_exec("mv VoxForgeDict.txt ../lexicon/");

//julius/model directory files

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
*/

echo "Downloading sample.conf"."\n";
shell_exec("wget -c https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sample.jconf");
?>

//shell_exec("wget -c");