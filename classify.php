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
  $sentimentData = new Opinion();
  $sentimentData->addToIndex('negativedata.txt', 'negative');
  $sentimentData->addToIndex('positivedata.txt', 'positive');
  
  //Add your data in a "$doc" variable.
  
  //Put sentances of string into array.
  $sentences = explode(".", $doc);
  
  //Create array for positive and negative sentiment
  $score = array('positive' => 0, 'negative' => 0);
  
  //Loop through sentances and find sentiment
  foreach($sentences as $sentence) {
          if(strlen(trim($sentence))) {
                  $class = $sentimentData->classify($sentence);
                 
                 //Add sentiment to sentiment score
                  $score[$class]++;
          }
  }
  
  //<do better> 
  //This isn't the cleanest it could be. If you can think of a better way of doing this, please tell me. cpopensource [at] gmail.com
  
  //Reverse sort the score in order to find the most likely sentiment (positive or negative)
  arsort($score);
  
  //To find how much bias there is (assurance), divide the positive sentiment score by the negative
  $assurance = $score['positive']/$score['negative'];
  
  //If the assurance is not a decimal...
  if($assurance>1){
      $assurance = $score['negative']/$score['positive'];
  }
  
  //Remove the least likey alternative 
  array_pop($score);
  
  //<do better/>
  
  //As the sentiment (positive and negative) are the keys in the array, find the key of the sentiment.
  $keyArray = array_keys($score);
  
  //If we're not sure (the assurance (above) is less than .47, its inconclusive. Otherwise, it's most likely good.
  if($assurance>.47){
      $sentiment = $keyArray[0];
  } else {
      $sentiment = "inconclusive";
  }
  
  //Echo out the sentiment
  echo $sentiment;
?>