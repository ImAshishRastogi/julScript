 # STEPS
 
 ## create sample.grammar in julius/model/
.grammar file: The rules governing the allowed words are defined in the .grammar file using a modified
BNF format.  A .grammar specification in Julius uses a set of derivation rules, written as: 

```
Symbol: [expression with Symbols]
```

where:\
Symbol is a nonterminal; and\
[expression with Symbols] is an expression which consists of sequences of Symbols, which can be terminals
and/or nonterminals.\
Example : [sample.grammar](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sample.grammar) \
How to create :  [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1) \

## create sample.voca in julius/model/
.voca file: The ".voca" file contains Word Definitions for each Word Category defined in the .grammar file. 
Each Word Category must be defined with "%" preceding it.  Word Definitions in each Word Category are
then defined one per line. The first column is the string which will be output when recognized, and
the rest is the pronunciation.  Spaces and/or tabs can act field separators.\
```
Format: 
%[Word Category]
[Word Definition]   [pronunciation ...]
CALL                k ao l
```
Example : [sample.voca](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/sample.voca) \
How to create :  [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-1)   \
(NOTE : To generate pronunciation of each word go to this link : [http://www.speech.cs.cmu.edu/tools/lextool.html](http://www.speech.cs.cmu.edu/tools/lextool.html) )\  
        
## create prompts.txt in julius/model/
create alternative sentences for words to be train.
```
Format :
*/sample[NUMBER]   [SENTENCE...]
*/sample1   CALL STEVE YOUNG BOB JOHNSON
```
Example : [prompts.txt](https://raw.githubusercontent.com/VoxForge/develop/master/tutorial/prompts.txt) \
How to create : [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-2](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-2) \

## create MyDict.txt in julius/lexicon/ with help of [VoxForgeDict.txt](https://raw.githubusercontent.com/VoxForge/develop/master/lexicon/VoxForgeDict.txt)
words to be train must be in present in MyDict.txt in lexicographical order.
```
Format :
[Word Definition]   [[Word]]    [pronunciation]
```

## generate wav files of samples of prompts.txt in julius/train/wav/
```
copy the sentence from prompts.txt and covert it in wav format and save as sample[NUMBER].wav 
accordingly in julius/train/wav/.
```
text to speech link : [http://www.fromtexttospeech.com/](http://www.fromtexttospeech.com/) \
mp3 to wav link :   [https://audio.online-convert.com/convert-to-wav](https://audio.online-convert.com/convert-to-wav) \
bit resolution: 16Bit \
sampling rate: 16000 Hz \
audio channels: mono \
Ref :  [http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-3](http://www.voxforge.org/home/dev/acousticmodels/linux/create/htkjulius/tutorial/data-prep/step-3)

## Run app.php
