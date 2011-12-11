**The tldr Project**   
*www.tldrproject.com*


   
*Sentiment Analysis for PHP*  


PHP sentiment analysis using bayesian opinion mining. This is my first time creating one of these (README files), 
sorry if it comes off as n00b-ish....



**AUTHORS**  

**Colin Poindexter** (cpopensource [at] gmail.com) for The tldr Project (www.tldrproject.com)

**Ian Black** (where the real heavy lifting for this came). Check out his blog here: http://www.phpir.com/

**Chuck Testa** http://www.youtube.com/watch?v=mbUVtfUWwF8


**DATA CITATION**
This data was first used in Bo Pang and Lillian Lee,
``Seeing stars: Exploiting class relationships for sentiment categorization
with respect to rating scales.'', Proceedings of the ACL, 2005.
  
@InProceedings{Pang+Lee:05a,
  author =       {Bo Pang and Lillian Lee},
  title =        {Seeing stars: Exploiting class relationships for sentiment
                  categorization with respect to rating scales},
  booktitle =    {Proceedings of the ACL},
  year =         2005
}



**DATA INFO**
positivedata.txt contains 5331 positive snippets

negativedata.txt contains 5331 negative snippets


Each line in these two files corresponds to a single snippet (usually
containing roughly one single sentence); all snippets are down-cased.  
The snippets were labeled automatically, as described below (see 
section "Label Decision").


**LABEL DECISION**
We assumed snippets (from Rotten Tomatoes webpages) for reviews marked with 
``fresh'' are positive, and those for reviews marked with ``rotten'' are
negative.

To make sure that the polarity of the data is real and not happenstance, 
we calculate the raw number of sentances for each bias, this creates the inital bias 
(either positive or negative, whichever has more).

Then we find out how equal these biases are. For every one incorrect bias sentance, 
there must be at least 2.1 bias sentances as stated by the aforementioned intial bias. 
If this threshold (.47) is not met, then the entire body is reclassified as being inconclusive 
(i.e. a story with 87 positive sentances and 88 negative sentances 
is not nessesarily negative, it just has a *very* slight slant).  


**CHANGELOG**  
v1 - Inception 


**INSTALL**  
You must have PHP 5.2.0 or newer running on your server.


**LICENSE**  
Copyright 2011 The tldr Project c/o ipsumedia Limited. 

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.



**BUGS**  
Has some problems with nuances, otherwise, none that I know of now. If you find any, 
don't hesitate to tell me: cpopensource [at] gmail [dot] com


