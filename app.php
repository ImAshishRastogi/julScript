<?php
 // before run it in julius/model/
/**  follow steps
 *   - create sample.grammar in julius/model/
 *   - create sample.voca in julius/model/
 *   - create prompts.txt in julius/model/
 *   - create MyDict.txt in julius/lexicon/
 *   - generate wav files of samples of prompts.txt in julius/train/wav/
 *   - run download_tools.php to download all required tools
*/
 
 //$tools_cmd = "php download_tools.php";
 //shell_exec($tools_cmd);
 
 
 echo "STEP1 START..."."\n";
/**  Step 1: Task Grammar
 *   - create a file called sample.grammar in your new 'julius/model' folder 
 *       .grammar file: The rules governing the allowed words are defined in the .grammar file using a modified
 *       BNF format.  A .grammar specification in Julius uses a set of derivation rules, written as:
 *       Symbol: [expression with Symbols]
 *       where:
 *       Symbol is a nonterminal; and
 *       [expression with Symbols] is an expression which consists of sequences of Symbols, which can be terminals
 *       and/or nonterminals. 
 *   
 *   - create a file called: sample.voca in your 'julius/model' folder
 *       .voca file: The ".voca" file contains Word Definitions for each Word Category defined in the .grammar file. 
 *       Each Word Category must be defined with "%" preceding it.  Word Definitions in each Word Category are
 *       then defined one per line. The first column is the string which will be output when recognized, and
 *       the rest is the pronunciation.  Spaces and/or tabs can act field separators.
 *       Format: 
 *       %[Word Category]
 *       [Word Definition]   [pronunciation ...]
 *
 *   - Compiling your Grammar
 *       The .grammar and .voca files now need to be compiled into ".dfa"  and ".dict" files so that Julius can
 *       use them. 
*/
 
 //Following command will genrate sample.dict , sample.term and sample.dfa
 
 $cmd11 = "julia ../bin/mkdfa.jl sample";
 shell_exec($cmd11);
 
 echo "STEP1 COMPLETED..."."\n";
 
 echo "STEP2 START..."."\n";
/**  Step 2:  Pronunciation Dictionnary
 *   - create a prompts.txt file in your 'julius/model' folder that includes our Grammar words and
 *       the additional dictionnary words required to create a phonetically balanced dictionnary.
 *       This file basically contains the list of words that need to be recorded, and the names of 
 *       the audio files the recordings will be stored - one per line. You will do these recordings in Step 3.
 *
 *   - generating wlist from prompts.txt with help of julia script prompts2wlist.jl.
 *       The Julia script prompts2wlist.jl can take the prompts.txt file you just created, and remove
 * the file name in the first column and print each word on one line into a word list file (wlist). 
*/
 $cmd21 = "julia ../bin/prompts2wlist.jl prompts.txt wlist";
 shell_exec($cmd21);
 
/**
 *   - next step is to add pronunciation information (i.e. the phonemes that make up the word) to 
 *       each of the words in the wlist file, thus creating a Pronunciation Dictionnary.
 *
 *   - create the global.ded script in your 'julius/model' folder (default script used by HDMan).
 *
 *   - Create a new directory called 'lexicon' in your 'julius' folder.  Create a new file called 
 *       my_lexicon in your 'julius/lexicon' folder, and copy the into it: VoxForgeDict.txt .  
 *       Execute the HDMan command from your 'julius/model' directory as follows:
*/
 
 $cmd22 = "HDMan -A -D -T 1 -m -w wlist -n monophones1 -i -l dlog dict ../lexicon/MyDict.txt";
 shell_exec($cmd22);
 
/**
 *       The output of the above noted HDMan command is two files:
 *       dict - the pronunciation dictionnary for you Grammar and additional words required to create
 *       a phonetically balanced Acoustic Model; and
 *       monophones1 - which is simply a list of the phones used in dict.
 *
 *   - Creating Monophones0 File
 *       You also need another monophones file for a later Step.  Simply copy the "monophones1" file to 
 *       a new "monophones0" file in your 'julius/model' directory and then remove the short-pause 
 *       "sp" entry in monophones0.
*/
 
 $cmd23 = "sed '/sp/d' monophones1 > monophones0";
 shell_exec($cmd23);
 echo "STEP2 COMPLETED..."."\n";
 
 echo "STEP3 START..."."\n";
/**  Step 3 : Recording the data
 *       set your 'Default Sample Rate Format' by clicking the up/down arrows to change it to 16000Hz;
 *       set your 'Default Sample Format' to 16-bit.
 *       set your 'Channels' to 1 (Mono).
 *       Then click the 'File Formats' tab, and then
 *       set your 'Uncompressed Export Format' to WAV.
*/
 echo "STEP3 COMPLETED..."."\n";
 
 echo "STEP4 START..."."\n";
/**  Step 4 - Creating the Transcription Files
 *   - Words Level Transcriptions 
 *       Download the Julia script prompts2mlf.jl to your julius/bin directory to generate the 
 *       mlf file from your prompts.txt file.  Execute the prompts2mlf script from your 'julius/model' 
 *       folder as follows:
 *       This script generates a words.mlf file.
*/
 
 $cmd41 = "julia ../bin/prompts2mlf.jl prompts.txt words.mlf";
 shell_exec($cmd41);
 
/**
 *   - Phone Level Transcriptions 
 *       First, create  the mkphones0.led edit script in your 'julius/model' folder.
 *       Then execute the following HLEd command from your 'julius/model' folder
 *       Which creates the phones0.mlf file
*/
 
 $cmd42 = "HLEd -A -D -T 1 -l '*' -d dict -i phones0.mlf mkphones0.led words.mlf";
 shell_exec($cmd42);
/**
 *       Next, we need to create a second phones1.mlf file (which will include short pauses (“sp”) 
 *       after each word phone group).  First create the mkphones1.led in your 'julius/model' 
 *       folder as follows:
 *       Which creates the phones1.mlf file.
*/
 
 $cmd43 = "HLEd -A -D -T 1 -l '*' -d dict -i phones1.mlf mkphones1.led words.mlf";
 shell_exec($cmd43);
 echo "STEP4 COMPLETED..."."\n";
 
 echo "STEP5 START..."."\n";
/** Step 5 : Coding the (Audio) Data
 *   - create a file containing a list of each source audio file and the name of the MFCC file 
 *       it will be converted to, and use that file as a parameter to the HCopy command.
 *   - Create the codetrain.scp HTK script file in your 'julius/model' folder.
*/
 
 
 // I have use 'sip' instead of 'sample' to save file name as
 
 shell_exec("sed 's/sample/sip/g' codetrain.scp > codetrain_new.scp");
 shell_exec("mv codetrain_new.scp codetrain.scp");
 
/**
 *   - Config file : The HCopy command performs the conversion from wav format to MFCC.  
 *       To do this, a configuration file (config) which specifies all the needed conversion 
 *       parameters is required.  Create a file called wav_config in your 'julius/model' folder.
*/
 
 $cmd51 = "HCopy -A -D -T 1 -C wav_config -S codetrain.scp";
 shell_exec($cmd51);
 
/**
 *       The result is the creation of a series of mfc files corresponding to the files listed in 
 *       your codetrain.scp script in the "julius/train/mfcc" folder.
*/
 echo "STEP5 COMPLETED..."."\n";
 
 echo "STEP6 START..."."\n";
/** Step 6 : Creating Flat Start Monophones
 *   -  Create a file called proto in your 'julius/model' directory.
 *   - You also need a configuration file.  Create a file called config in your 'julius/model' directory.
 *   - You also need to tell HTK where all your feature vector files are located (those are the mfcc files 
 *       you created in the last step).  You do this with an HTK script file.  Therefore, create a file called 
 *       train.scp.
*/
 
 // I have use 'sip' instead of 'sample' to save file name as
 
 shell_exec("sed 's/sample/sip/g' train.scp > train_new.scp");
 shell_exec("mv train_new.scp train.scp");
 
/**  - The next step is to create a new folder called hmm0. 
 *   - Then create a new version of proto in the hmm0 folder - using the HTK  HCompV tool as follows:
*/
 
 $cmd61 = "HCompV -A -D -T 1 -C config -f 0.01 -m -S train.scp -M hmm0 proto";
 shell_exec($cmd61);
 
/**
 *       This creates two files in the hmm0 folder:
 *       > proto
 *       > vFloors
*/
/**

 *   - create 'hmmdefs'
 *       Create a new file called hmmdefs in your 'julius/model/hmm0' folder:
 *           > Copy the  monophones0 file to your hmm0 folder;
 *           > rename the monophones0 file to hmmdefs;
*/

shell_exec("cp monophones0 hmm0/hmmdefs");

/**
 *      For each phone in hmmdefs: 
 *           > put the phone in double quotes;
 *           > add '~h ' before the phone (note the space after the '~h'); and
 *           > copy from line 5 onwards (i.e. starting from "<BEGINHMM>" to "<ENDHMM>") of the 
 *           hmm0/proto file and paste it after each phone.
 *           > Leave one blank line at the end of your file.
 */
$addstr = '~h "';
$str ='';

$monophones0 = fopen("monophones0","r+");
while($line = fgets($monophones0)){
    $str .= $addstr.$line;
}
fclose($monophones0);

$hmmdefs0 = fopen("hmm0/hmmdefs","w+");
fwrite($hmmdefs0,$str);
fclose($hmmdefs0);


$addstr1 = file_get_contents("hmm0/proto");
$split = explode('~h "proto"'.PHP_EOL,$addstr1,2);

$addstr = '"'.PHP_EOL.$split[1];
$str='';
$hmmdefs0 = fopen("hmm0/hmmdefs","r+");
while($leter = fgetc($hmmdefs0)){
    if($leter == PHP_EOL)
    $str .= $addstr;
    else
    $str .= $leter;
}
$str .= PHP_EOL;
fclose($hmmdefs0);

$hmmdefs0 = fopen("hmm0/hmmdefs","w+");
fwrite($hmmdefs0,$str);
fclose($hmmdefs0);

/**
 *   - Create 'macros' File
 *       The final step in this section is to create the macros file.
 *       A new file called macros should be created and stored in your 'julius/model/hmm0' folder:
 *           > create a new file called macros in hmm0;
 *           > copy vFloors to macros
 *           > copy the first 3 lines of proto (from ~o to <DIAGC>) and add them to the top of the macros file
 */

$str = $split[0];
$str .=file_get_contents("hmm0/vFloors");
$macros0 = fopen("hmm0/macros","w+");
fwrite($macros0,$str);
fclose($macros0);

/*
*   - Re-estimate Monophones
*       The Flat Start Monophones are re-estimated using the HERest tool.  The purpose of this is to load 
*       all the models in the hmm0 folder (these are contained in the hmmdefs file), and re-estimate them 
*       using the MFCC files listed in the train.scp script, and create a new model set in hmm1.   
*       Execute the HERest command from your 'julius/model' directory:
*/

$cmd62 = "HERest -A -D -T 1 -C config -I phones0.mlf -t 250.0 150.0 1000.0 -S train.scp -H hmm0/macros -H hmm0/hmmdefs -M hmm1 monophones0";
shell_exec($cmd62);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd63 = "HERest -A -D -T 1 -C config -I phones0.mlf -t 250.0 150.0 1000.0 -S train.scp -H hmm1/macros -H hmm1/hmmdefs -M hmm2 monophones0";
shell_exec($cmd63);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd64 = "HERest -A -D -T 1 -C config -I phones0.mlf -t 250.0 150.0 1000.0 -S train.scp -H hmm2/macros -H hmm2/hmmdefs -M hmm3 monophones0";
shell_exec($cmd64);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/
echo "STEP6 COMPLETED..."."\n";

echo "STEP7 START..."."\n";
/** Step 7 - Fixing the Silence Models
 *   - First copy the contents of the hmm3 folder to hmm4.  Then using an editor, 
 *       create new "sp" model in hmm4/hmmdefs as follows:
 *           > copy and paste the “sil” model and rename the new one “sp”(don't delete your old 
 *           "sil" model, you will need it - just make a copy of it)
 *           > remove state 2 and 4 from new “sp” model (i.e. keep 'centre state' of old “sil” 
 *           model in new “sp” model)
 *           > change <NUMSTATES> to 3
 *           > change <STATE> to 2
 *           > change <TRANSP> to 3
 *           > change matrix in <TRANSP> to 3 by 3 array
 *               0.0 1.0 0.0
 *               0.0 0.9 0.1
 *               0.0 0.0 0.0
*/

shell_exec("cp hmm3/* hmm4/");
$str = file_get_contents('hmm4/hmmdefs');
$split = explode('~h "sil"',$str);
$str = '~h "sp"'.$split[1];
$split = preg_split('/<STATE> [0-9]/',$str);
$str = $split[0].'<STATE> 2'.$split[2];
$split = preg_split('/<NUMSTATES> [0-9]/',$str);
$str = $split[0].'<NUMSTATES> 3'.$split[1].'<TRANSP> 3'.PHP_EOL;
$str .= ' 0.0 1.0 0.0 '.PHP_EOL;
$str .= ' 0.0 0.9 0.1 '.PHP_EOL;
$str .= ' 0.0 0.0 0.0 '.PHP_EOL;
$str .= '<ENDHMM>';

$hmmdefs4 = fopen("hmm4/hmmdefs","a+");
fwrite($hmmdefs4,$str);
fclose($hmmdefs4);

/** 
*   - run the HMM editor called HHEd to "tie" the sp state to the sil centre state - 
*       tying means that one or more HMMs share the same set of parameters.  To do this you need 
*       to create the following HHEd command script, called sil.hed, in your voxforge/tutorial folder:
*/

$cmd71 = "HHEd -A -D -T 1 -H hmm4/macros -H hmm4/hmmdefs -M hmm5 sil.hed monophones1";
shell_exec($cmd71);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd72 = "HERest -A -D -T 1 -C config  -I phones1.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm5/macros -H  hmm5/hmmdefs -M hmm6 monophones1";
shell_exec($cmd72);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/$cmd73 = "HERest -A -D -T 1 -C config  -I phones1.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm6/macros -H hmm6/hmmdefs -M hmm7 monophones1";
shell_exec($cmd73);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/
echo "STEP7 COMPLETED..."."\n";

echo "STEP8 START..."."\n";
/* Step 8 - Realigning the Training Data
*   - Execute the HVite command as follows:
*/

$cmd81 = "HVite -A -D -T 1 -l '*' -o SWT -b SENT-END -C config -H hmm7/macros -H hmm7/hmmdefs -i aligned.mlf -m -t 250.0 150.0 1000.0 -y lab -a -I words.mlf -S train.scp dict monophones1> HVite_log";
shell_exec($cmd81);

/*
*       This creates the aligned.mlf file.
*   - Next run HERest 2 more times: 
*/

$cmd82 = "HERest -A -D -T 1 -C config -I aligned.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm7/macros -H hmm7/hmmdefs -M hmm8 monophones1";
shell_exec($cmd82);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd83 = "HERest -A -D -T 1 -C config -I aligned.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm8/macros -H hmm8/hmmdefs -M hmm9 monophones1";
shell_exec($cmd83);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/
echo "STEP8 COMPLETED..."."\n";

echo "STEP9 START..."."\n";
/* Step 9 - Making Triphones from Monophones
*       To convert the monophone transcriptions in the aligned.mlf file you created in Step 8 to an 
*       equivalent set of triphone transcriptions, you need to execute the HLEd command.
*   - First you need to create the mktri.led edit script:
*       WB sp
*       WB sil
*       TC
*
*   - Then you execute the HLEd (label file editor) command as follows:
*/

$cmd91 = "HLEd -A -D -T 1 -n triphones1 -l '*' -i wintri.mlf mktri.led aligned.mlf";
shell_exec($cmd91);

/*
*       This creates 2 files:
*       > wintri.mlf (triphone multi label file)
*       > triphones1 (list of triphones in your training set)
*
*   - Next, download the Julia script mktrihed.jl to your 'julius/bin' folder, 
*       then create the mktri.hed file by executing:
*/

$cmd92 = "julia ../bin/mktrihed.jl monophones1 triphones1 mktri.hed";
shell_exec($cmd92);

/*
*       This creates the mktri.hed file. This file contains a clone command 'CL' followed by a 
*       series of 'TI' commands to 'tie' HMMs so that they share the same set of parameters.
*   - Next, execute the HHEd command:
*/

$cmd93 = "HHEd -A -D -T 1 -H hmm9/macros -H hmm9/hmmdefs -M hmm10 mktri.hed monophones1";
shell_exec($cmd93);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*
*   - Next run HERest 2 more times:
*/

$cmd94 = "HERest  -A -D -T 1 -C config -I wintri.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm10/macros -H hmm10/hmmdefs -M hmm11 triphones1";
shell_exec($cmd94);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd95 = "HERest  -A -D -T 1 -C config -I wintri.mlf -t 250.0 150.0 3000.0 -s stats -S train.scp -H hmm11/macros -H hmm11/hmmdefs -M hmm12 triphones1";
shell_exec($cmd95);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*       > stats (file needed for state-clustering in step 10)
*/
echo "STEP9 COMPLETED..."."\n";

echo "STEP10 START..."."\n";
/*  Step 10 - Making Tied-State Triphones
*   - Create a new HTK script file called maketriphones.ded containing the following:
*       AS sp
*       MP sil sil sp
*       TC
*
*   - Then execute the HDMan command against the entire lexicon file, not just the training 
*       dictionnary we have used thus far:
*/

$cmd101 = "HDMan -A -D -T 1 -b sp -n fulllist0 -g maketriphones.ded -l flog dict-tri ../lexicon/MyDict.txt";
shell_exec($cmd101);

/*
*       this creates 2 files:
*       > dict-tri
*       > fulllist0
*
*   - Next, download the Julia script fixfulllist.jl to your 'julius/bin' folder and run it to 
*       append the contents of monophones0 to the beginning of to the fulllist0 file, and then to to 
*       remove any duplicate entries, and put the result in fulllist: 
*/

$cmd102 = "julia ../bin/fixfulllist.jl fulllist0 monophones0 fulllist";
shell_exec($cmd102);

/*
*   - tree.hed : Next you create a new HTK script called tree.hed in your 'julius/model' folder \
*       containing the following:  tree1.hed (Note: make sure you have a blank line at the 
*       end of this file).  copy contents of tree1.hed to tree.hed:
*/

shell_exec("cat tree1.hed > tree.hed");

/*
*   - Next download the mkclscript.jl script to your 'voxforge/bin' folder and run it as follows to 
*       append the state clusters to the tree.hed file you created above:
*/

$cmd103 = "julia ../bin/mkclscript.jl monophones0 tree.hed";
shell_exec($cmd103);

/*
*   - Then execute the HHEd (hmm definition editor) command:
*/

$cmd104 = "HHEd -A -D -T 1 -H hmm12/macros -H hmm12/hmmdefs -M hmm13 tree.hed triphones1";
shell_exec($cmd104);

/*
*       This command creates 3 files:
*       > hmmdefs
*       > macros
*       > tiedlist
*
*   -  Next run HERest 2 more times: 
*/

$cmd105 = "HERest -A -D -T 1 -T 1 -C config -I wintri.mlf  -t 250.0 150.0 3000.0 -S train.scp -H hmm13/macros -H hmm13/hmmdefs -M hmm14 tiedlist";
shell_exec($cmd105);

/*
*       This command creates 2 files:
*       > hmmdefs
*       > macros
*/

$cmd106 = "HERest -A -D -T 1 -T 1 -C config -I wintri.mlf  -t 250.0 150.0 3000.0 -S train.scp -H hmm14/macros -H hmm14/hmmdefs -M hmm15 tiedlist";
shell_exec($cmd106);

/*
*       This creates 2 files:
*       > hmmdefs
*       > macros
*/
echo "STEP10 COMPLETED..."."\n";



?>