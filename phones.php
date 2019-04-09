<?php
echo "STEP8 START..."."\n";
/* Step 8 - Realigning the Training Data
*   - Execute the HVite command as follows:
*/

$cmd10 = "HVite -A -D -T 1 -l '*' -o SWT -b SENT-END -C config -H hmm7/macros -H hmm7/hmmdefs -i aligned.mlf -m -t 250.0 150.0 1000.0 -y lab -a -I words.mlf -S train.scp dict monophones1> HVite_log";
shell_exec($cmd10);

/*
*       This creates the aligned.mlf file.
*   - Next run HERest 2 more times: 
*/

$cmd11 = "HERest -A -D -T 1 -C config -I aligned.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm7/macros -H hmm7/hmmdefs -M hmm8 monophones1";
shell_exec($cmd11);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd12 = "HERest -A -D -T 1 -C config -I aligned.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm8/macros -H hmm8/hmmdefs -M hmm9 monophones1";
shell_exec($cmd12);

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

$cmd13 = "HLEd -A -D -T 1 -n triphones1 -l '*' -i wintri.mlf mktri.led aligned.mlf";
shell_exec($cmd13);

/*
*       This creates 2 files:
*       > wintri.mlf (triphone multi label file)
*       > triphones1 (list of triphones in your training set)
*
*   - Next, download the Julia script mktrihed.jl to your 'julius/bin' folder, 
*       then create the mktri.hed file by executing:
*/

$cmd14 = "julia ../bin/mktrihed.jl monophones1 triphones1 mktri.hed";
shell_exec($cmd14);

/*
*       This creates the mktri.hed file. This file contains a clone command 'CL' followed by a 
*       series of 'TI' commands to 'tie' HMMs so that they share the same set of parameters.
*   - Next, execute the HHEd command:
*/

$cmd15 = "HHEd -A -D -T 1 -H hmm9/macros -H hmm9/hmmdefs -M hmm10 mktri.hed monophones1";
shell_exec($cmd15);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*
*   - Next run HERest 2 more times:
*/

$cmd16 = "HERest  -A -D -T 1 -C config -I wintri.mlf -t 250.0 150.0 3000.0 -S train.scp -H hmm10/macros -H hmm10/hmmdefs -M hmm11 triphones1";
shell_exec($cmd16);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd17 = "HERest  -A -D -T 1 -C config -I wintri.mlf -t 250.0 150.0 3000.0 -s stats -S train.scp -H hmm11/macros -H hmm11/hmmdefs -M hmm12 triphones1";
shell_exec($cmd17);

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

$cmd18 = "HDMan -A -D -T 1 -b sp -n fulllist0 -g maketriphones.ded -l flog dict-tri ../lexicon/MyDict.txt";
shell_exec($cmd18);

/*
*       this creates 2 files:
*       > dict-tri
*       > fulllist0
*
*   - Next, download the Julia script fixfulllist.jl to your 'julius/bin' folder and run it to 
*       append the contents of monophones0 to the beginning of to the fulllist0 file, and then to to 
*       remove any duplicate entries, and put the result in fulllist: 
*/

$cmd19 = "julia ../bin/fixfulllist.jl fulllist0 monophones0 fulllist";
shell_exec($cmd19);

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

$cmd20 = "julia ../bin/mkclscript.jl monophones0 tree.hed";
shell_exec($cmd20);

/*
*   - Then execute the HHEd (hmm definition editor) command:
*/

$cmd21 = "HHEd -A -D -T 1 -H hmm12/macros -H hmm12/hmmdefs -M hmm13 tree.hed triphones1";
shell_exec($cmd21);

/*
*       This command creates 3 files:
*       > hmmdefs
*       > macros
*       > tiedlist
*
*   -  Next run HERest 2 more times: 
*/

$cmd22 = "HERest -A -D -T 1 -T 1 -C config -I wintri.mlf  -t 250.0 150.0 3000.0 -S train.scp -H hmm13/macros -H hmm13/hmmdefs -M hmm14 tiedlist";
shell_exec($cmd22);

/*
*       This command creates 2 files:
*       > hmmdefs
*       > macros
*/

$cmd23 = "HERest -A -D -T 1 -T 1 -C config -I wintri.mlf  -t 250.0 150.0 3000.0 -S train.scp -H hmm14/macros -H hmm14/hmmdefs -M hmm15 tiedlist";
shell_exec($cmd23);

/*
*       This creates 2 files:
*       > hmmdefs
*       > macros
*/
echo "STEP10 COMPLETED..."."\n";





?>