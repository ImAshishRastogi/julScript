<?php
/*  Before Run this script perform following:
*   - create hmmdefs
*       Create a new file called hmmdefs in your 'julius/model/hmm0' folder:
*           > Copy the  monophones0 file to your hmm0 folder;
*           > rename the monophones0 file to hmmdefs;
*       For each phone in hmmdefs: 
*           > put the phone in double quotes;
*           > add '~h ' before the phone (note the space after the '~h'); and
*           > copy from line 5 onwards (i.e. starting from "<BEGINHMM>" to "<ENDHMM>") of the 
*           hmm0/proto file and paste it after each phone.
*           > Leave one blank line at the end of your file.
*   - Create macros File
*       The final step in this section is to create the macros file.
*       A new file called macros should be created and stored in your 'julius/model/hmm0' folder:
*           > create a new file called macros in hmm0;
*           > copy vFloors to macros
*           > copy the first 3 lines of proto (from ~o to <DIAGC>) and add them to the top of the macros file
*
*/

/*
*   - Re-estimate Monophones
*       The Flat Start Monophones are re-estimated using the HERest tool.  The purpose of this is to load 
*       all the models in the hmm0 folder (these are contained in the hmmdefs file), and re-estimate them 
*       using the MFCC files listed in the train.scp script, and create a new model set in hmm1.   
*       Execute the HERest command from your 'julius/model' directory:
*/

$cmd61 = "HERest -A -D -T 1 -C config -I phones0.mlf -t 250.0 150.0 1000.0 -S train.scp -H hmm0/macros -H hmm0/hmmdefs -M hmm1 monophones0";
shell_exec($cmd61);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd62 = "HERest -A -D -T 1 -C config -I phones0.mlf -t 250.0 150.0 1000.0 -S train.scp -H hmm1/macros -H hmm1/hmmdefs -M hmm2 monophones0";
shell_exec($cmd62);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/

$cmd63 = "HERest -A -D -T 1 -C config -I phones0.mlf -t 250.0 150.0 1000.0 -S train.scp -H hmm2/macros -H hmm2/hmmdefs -M hmm3 monophones0";
shell_exec($cmd63);

/*
*       The files created by this command are:
*       > hmmdefs
*       > macros
*/
echo "STEP6 COMPLETED..."."\n";
echo "Now go to step7"."\n";



?>