<?php
// before run it in julius/model/
/*  follow steps
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
/*  Step 1: Task Grammar
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

$cmd1 = "julia ../bin/mkdfa.jl sample";
shell_exec($cmd1);

echo "STEP1 COMPLETED..."."\n";

echo "STEP2 START..."."\n";
/*  Step 2:  Pronunciation Dictionnary
*   - create a prompts.txt file in your 'julius/model' folder that includes our Grammar words and
*       the additional dictionnary words required to create a phonetically balanced dictionnary.
*       This file basically contains the list of words that need to be recorded, and the names of 
*       the audio files the recordings will be stored - one per line. You will do these recordings in Step 3.
*
*   - generating wlist from prompts.txt with help of julia script prompts2wlist.jl.
*       The Julia script prompts2wlist.jl can take the prompts.txt file you just created, and remove
 the file name in the first column and print each word on one line into a word list file (wlist). 
*/
$cmd2 = "julia ../bin/prompts2wlist.jl prompts.txt wlist";
shell_exec($cmd2);

/*
*   - next step is to add pronunciation information (i.e. the phonemes that make up the word) to 
*       each of the words in the wlist file, thus creating a Pronunciation Dictionnary.
*
*   - create the global.ded script in your 'julius/model' folder (default script used by HDMan).
*
*   - Create a new directory called 'lexicon' in your 'julius' folder.  Create a new file called 
*       my_lexicon in your 'julius/lexicon' folder, and copy the into it: VoxForgeDict.txt .  
*       Execute the HDMan command from your 'julius/model' directory as follows:
*/

$cmd3 = "HDMan -A -D -T 1 -m -w wlist -n monophones1 -i -l dlog dict ../lexicon/MyDict.txt";
shell_exec($cmd3);

/*
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

$cmd4 = "sed '/sp/d' monophones1 > monophones0";
shell_exec($cmd4);
echo "STEP2 COMPLETED..."."\n";

echo "STEP3 START..."."\n";
/*  Step 3 : Recording the data
*       set your 'Default Sample Rate Format' by clicking the up/down arrows to change it to 16000Hz;
*       set your 'Default Sample Format' to 16-bit.
*       set your 'Channels' to 1 (Mono).
*       Then click the 'File Formats' tab, and then
*       set your 'Uncompressed Export Format' to WAV.
*/
echo "STEP3 COMPLETED..."."\n";

echo "STEP4 START..."."\n";
/*  Step 4 - Creating the Transcription Files
*   - Words Level Transcriptions 
*       Download the Julia script prompts2mlf.jl to your julius/bin directory to generate the 
*       mlf file from your prompts.txt file.  Execute the prompts2mlf script from your 'julius/model' 
*       folder as follows:
*       This script generates a words.mlf file.
*/

$cmd5 = "julia ../bin/prompts2mlf.jl prompts.txt words.mlf";
shell_exec($cmd5);

/*
*   - Phone Level Transcriptions 
*       First, create  the mkphones0.led edit script in your 'julius/model' folder.
*       Then execute the following HLEd command from your 'julius/model' folder
*       Which creates the phones0.mlf file
*/

$cmd6 = "HLEd -A -D -T 1 -l '*' -d dict -i phones0.mlf mkphones0.led words.mlf";
shell_exec($cmd6);
/*
*       Next, we need to create a second phones1.mlf file (which will include short pauses (“sp”) 
*       after each word phone group).  First create the mkphones1.led in your 'julius/model' 
*       folder as follows:
*       Which creates the phones1.mlf file.
*/

$cmd7 = "HLEd -A -D -T 1 -l '*' -d dict -i phones1.mlf mkphones1.led words.mlf";
shell_exec($cmd7);
echo "STEP4 COMPLETED..."."\n";

echo "STEP5 START..."."\n";
/*  Step 5 : Coding the (Audio) Data
*   - create a file containing a list of each source audio file and the name of the MFCC file 
*       it will be converted to, and use that file as a parameter to the HCopy command.
*   - Create the codetrain.scp HTK script file in your 'julius/model' folder.
*/


// I have use 'sip' instead of 'sample' to save file name as

shell_exec("sed 's/sample/sip/g' codetrain.scp > codetrain_new.scp");
shell_exec("mv codetrain_new.scp codetrain.scp");

/*
*   - Config file : The HCopy command performs the conversion from wav format to MFCC.  
*       To do this, a configuration file (config) which specifies all the needed conversion 
*       parameters is required.  Create a file called wav_config in your 'julius/model' folder.
*/

$cmd8 = "HCopy -A -D -T 1 -C wav_config -S codetrain.scp";
shell_exec($cmd8);

/*\
*       The result is the creation of a series of mfc files corresponding to the files listed in 
*       your codetrain.scp script in the "julius/train/mfcc" folder.
*/
echo "STEP5 COMPLETED..."."\n";

echo "STEP6 START..."."\n";
/* Step 6 : Creating Flat Start Monophones
*   -  Create a file called proto in your 'julius/model' directory.
*   - You also need a configuration file.  Create a file called config in your 'julius/model' directory.
*   - You also need to tell HTK where all your feature vector files are located (those are the mfcc files 
*       you created in the last step).  You do this with an HTK script file.  Therefore, create a file called 
*       train.scp.
*/

// I have use 'sip' instead of 'sample' to save file name as

shell_exec("sed 's/sample/sip/g' train.scp > train_new.scp");
shell_exec("mv train_new.scp train.scp");

/*   - The next step is to create a new folder called hmm0. 
*   - Then create a new version of proto in the hmm0 folder - using the HTK  HCompV tool as follows:
*/

$cmd9 = "HCompV -A -D -T 1 -C config -f 0.01 -m -S train.scp -M hmm0 proto";
shell_exec($cmd9);

/*
*       This creates two files in the hmm0 folder:
*       > proto
*       > vFloors
*/

/*  - Flat Start Monophones
*       perform this task manually
*       Go to http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/monophones/step-6
*/

echo "Perform step 6 and 7 manually OR follow INSTRUCTION (Go Through julius/model/INSTRUCTION)"."\n";
echo "NOTE : perform all action corresponding to 'julius/model' directory"."\n";


?>