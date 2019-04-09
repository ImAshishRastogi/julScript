<?php
/*  Before Run this script perform following:
*       - First copy the contents of the hmm3 folder to hmm4.  Then using an editor, 
*       create new "sp" model in hmm4/hmmdefs as follows:
*           > copy and paste the “sil” model and rename the new one “sp”(don't delete your old 
*           "sil" model, you will need it - just make a copy of it)
*           > remove state 2 and 4 from new “sp” model (i.e. keep 'centre state' of old “sil” 
*           model in new “sp” model)
*           > change <NUMSTATES> to 3
*           > change <STATE> to 2
*           > change <TRANSP> to 3
*           > change matrix in <TRANSP> to 3 by 3 array
*           > change numbers in matrix as follows:
*               0.0 1.0 0.0
*               0.0 0.9 0.1
*               0.0 0.0 0.0
*/

echo "STEP7 START..."."\n";
/* Step 7 - Fixing the Silence Models
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

?>