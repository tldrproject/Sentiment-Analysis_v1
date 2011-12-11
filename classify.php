<?php
  //Sentiment Analysis (Classification) using bayesian Opinion Mining
  //Copyright 2011 The tldr Project c/o ipsumedia Limited. 

  //Licensed under the Apache License, Version 2.0 (the "License");
  //you may not use this file except in compliance with the License.
  //You may obtain a copy of the License at

      //http://www.apache.org/licenses/LICENSE-2.0

  //Unless required by applicable law or agreed to in writing, software
  //distributed under the License is distributed on an "AS IS" BASIS,
  //WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  //See the License for the specific language governing permissions and
  //limitations under the License.
  
  include('Opinion.class.php');
  $op = new Opinion();
  $op->addToIndex('negativedata.txt', 'negative');
  $op->addToIndex('positivedata.txt', 'positive');
  
  //Add your data in a "$doc" variable.
  $sentences = explode(".", $doc);
  $score = array('positive' => 0, 'negative' => 0);
  foreach($sentences as $sentence) {
          if(strlen(trim($sentence))) {
                  $class = $op->classify($sentence);
                  $score[$class]++;
          }
  }
  
  //<do better> 
  //This isn't the cleanest it could be. If you can think of a better way of doing this, please tell me. cpopensource [at] gmail.com
  arsort($score);
  $assurance = $score['positive']/$score['negative'];
  if($assurance>1){
      $assurance = $score['negative']/$score['positive'];
  } 
  array_pop($score);
  
  //</do better>
  
  $keyArray = array_keys($score);
  if($assurance>.4){
      $sentiment = $keyArray[0];
  } else {
      $sentiment = "inconclusive";
  }
  echo $sentiment;
?>