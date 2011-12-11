<?php

/* 
Sentiment Analysis (Opinion Class) using bayesian Opinion Mining
Copyright 2011 The tldr Project c/o ipsumedia Limited. Opinion class taken from Ian Barber's 
Bayesian Opinion Mining found at: http://www.phpir.com/bayesian-opinion-mining


LICENSE: 
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

class Opinion {
        private $index = array();
        private $classes = array('positive', 'negative');
        private $classTokCounts = array('positive' => 0, 'negative' => 0);
        private $tokCount = 0;
        private $classDocCounts = array('positive' => 0, 'negative' => 0);
        private $docCount = 0;
        private $prior = array('positive' => 0.5, 'negative' => 0.5);
        
        
        /* Add the known data to the index. Takes a text file, and a sentiment (either positive or negative), 
        and if you want to limit the amount of sentiment data analyzed, 
        enter the number of lines you want to sample as $limit. Defaults to 0. 
        */
        public function addToIndex($file, $class, $limit = 0) {
                $fh = fopen($file, 'r');
                $i = 0;
                if(!in_array($class, $this->classes)) {
                        echo "Invalid class specified\n";
                        return;
                }
                while($line = fgets($fh)) {
                        if($limit > 0 && $i > $limit) {
                                break;
                        }
                        $i++;
                       
                        $this->docCount++;
                        $this->classDocCounts[$class]++;
                        $tokens = $this->tokenise($line);
                        foreach($tokens as $token) {
                                if(!isset($this->index[$token][$class])) {
                                        $this->index[$token][$class] = 0;
                                }
                                $this->index[$token][$class]++;
                                $this->classTokCounts[$class]++;
                                $this->tokCount++;
                        }
                }
                fclose($fh);
        }
       
       // Classify the data. Takes a string as a parameter.
        public function classify($document) {
                $this->prior['positive'] = $this->classDocCounts['positive'] / $this->docCount;
                $this->prior['negative'] = $this->classDocCounts['negative'] / $this->docCount;
                $tokens = $this->tokenise($document);
                $classScores = array();

                foreach($this->classes as $class) {
                        $classScores[$class] = 1;
                        foreach($tokens as $token) {
                                $count = isset($this->index[$token][$class]) ?
                                        $this->index[$token][$class] : 0;

                                $classScores[$class] *= ($count + 1) /
                                        ($this->classTokCounts[$class] + $this->tokCount);
                        }
                        $classScores[$class] = $this->prior[$class] * $classScores[$class];
                }
               
                arsort($classScores);
                return key($classScores);
        }
        
        //Find matches in either positive or negative sentiment. Takes a string as a paremeter.
        private function tokenise($document) {
                $document = strtolower($document);
                preg_match_all('/\w+/', $document, $matches);
                return $matches[0];
        }
}
?>