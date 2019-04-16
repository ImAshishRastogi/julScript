 # STEPS
 
## 1. create sample.grammar in julius/model/
<<<<<<< HEAD
.grammar file: The rules governing the allowed words are defined in the .grammar file using a modified
=======
>.grammar file: The rules governing the allowed words are defined in the .grammar file using a modified
>>>>>>> 1ecde0f67068f01851284b882420a0e66123de2f
BNF format.  A .grammar specification in Julius uses a set of derivation rules, written as: 

```
Symbol: [expression with Symbols]
```
>where:\
Symbol is a nonterminal; and\
[expression with Symbols] is an expression which consists of sequences of Symbols, which can be terminals
and/or nonterminals.\
Example : [sample.grammar](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sample.grammar) \
How to create :  [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1) 

## 2. create sample.voca in julius/model/
<<<<<<< HEAD
.voca file: The ".voca" file contains Word Definitions for each Word Category defined in the .grammar file. 
=======
>.voca file: The ".voca" file contains Word Definitions for each Word Category defined in the .grammar file. 
>>>>>>> 1ecde0f67068f01851284b882420a0e66123de2f
Each Word Category must be defined with "%" preceding it.  Word Definitions in each Word Category are
then defined one per line. The first column is the string which will be output when recognized, and
the rest is the pronunciation.  Spaces and/or tabs can act field separators.
```
Format: 
%[Word Category]
[Word Definition]   [pronunciation ...]
CALL                k ao l
```
>Example : [sample.voca](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sample.voca) \
How to create :  [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1)   \
(NOTE : To generate pronunciation of each word go to this link : [http://www.speech.cs.cmu.edu/tools/lextool.html](http://www.speech.cs.cmu.edu/tools/lextool.html) )
        
## 3. create prompts.txt in julius/model/
<<<<<<< HEAD
create alternative sentences for words to be train.
=======
>create alternative sentences for words to be train.
>>>>>>> 1ecde0f67068f01851284b882420a0e66123de2f
```
Format :
*/sample[NUMBER]   [SENTENCE...]
*/sample1   CALL STEVE YOUNG BOB JOHNSON
```
>Example : [prompts.txt](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/prompts.txt) \
How to create : [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-2](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-2) 

## 4. create MyDict.txt in julius/lexicon/ with help of [VoxForgeDict.txt](https://raw.githubusercontent.com/VoxForge/develop/master/lexicon/VoxForgeDict.txt)
<<<<<<< HEAD
words to be train must be in present in MyDict.txt in lexicographical order.
=======
>words to be train must be in present in MyDict.txt in lexicographical order.
>>>>>>> 1ecde0f67068f01851284b882420a0e66123de2f
```
Format :
[Word Definition]   [[Word]]    [pronunciation]
```

## 5. generate wav files of samples of prompts.txt in julius/train/wav/
```
copy the sentence from prompts.txt and covert it in wav format and save as sample[NUMBER].wav 
accordingly in julius/train/wav/.
```
>text to speech link : [http://www.fromtexttospeech.com/](http://www.fromtexttospeech.com/) \
mp3 to wav link :   [https://audio.online-convert.com/convert-to-wav](https://audio.online-convert.com/convert-to-wav) 
```
bit resolution: 16Bit 
sampling rate: 16000 Hz 
audio channels: mono 
```
>Ref :  [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-3](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-3)

## 6. modify train.scp and codetrain.scp 
- codetrain.scp: containing a list of each source audio file(.wav) and the name of the MFCC file it will be converted.
```
Format:
../train/wav/sample1.wav ../train/mfcc/sample1.mfc
```
Example : [codetrain.scp](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/codetrain.scp) 
- train.scp: containing a list of each MFCC file.
```
Format:
../train/mfcc/sample1.mfc
```
Example : [train.scp](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/train.scp) 

<<<<<<< HEAD
## 6. Run app.php
=======
## 7. Run app.php
>>>>>>> 1ecde0f67068f01851284b882420a0e66123de2f
