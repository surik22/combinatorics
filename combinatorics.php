<?php
class Combinatorics {
    protected $marbles;
    protected $holes;
    protected $filename;
    protected $errorMsg;
    protected $combinations = [];

    //HIGHLY ADVISED TO KEEP IT ON
    protected $strict_mode = "on";

    function __construct($marbles, $holes, $filename) {
        $this->marbles = $marbles;
        $this->holes = $holes;
        $this->filename = ($filename) ? $filename : "combinatorics";
        if($this->checkStrictMode()){
            $result = $this->createPatternSpaceMap();
            $combinations = [];
            if(!empty($result)) {
                foreach($result as $item) {
                    $pattern = $this->drawPattern($item);
                    $tempCombination = $this->drawCombination($pattern);
                    $combinations = array_merge($combinations, $tempCombination);
                }
            }
            $this->writeToFile($combinations);
        }
    }

    /**
     * get number of combinations
     * @return [int] number of possible unique combinations
     */
    private function getCombinationNumber() {
      $j = $res = 1;

      if($this->marbles < 0 || $this->marbles > $this->holes)
         return 0;
      if(($this->holes - $this->marbles) < $this->marbles)
         $this->marbles = $this->holes - $this->marbles;

      while($j <= $this->marbles) {
         $res *= $this->holes--;
         $res /= $j++;
      }
      return $res;
   }

    /**
     * return error message
     * @return [string] error message
     */
    public function getErrorMsg() {
        return $this->errorMsg;
    }

    /**
     * check if sctrict mode enabled and restrict for big input
     * @return [boolean]
     */
    private function checkStrictMode() {
        if($this->strict_mode == "on") {
            if($this->holes > 10 || $this->holes < $this->marbles) {
                $this->errorMsg =
                    "<div class='alert alert-danger'>
                        <strong>Пожалуйста введите числа поменьше</strong>
                    </div>";
                return false;
            }
            else {
                return true;
            }
        }
        else {
            return true;
        }
    }

    /**
     * create map with possible pattern spaces
     * @return [array]
     */
    private function createPatternSpaceMap() {
        $a = [];
        for ($i=1; $i<$this->marbles; $i++) {
            $a[] = range(0, $this->holes);
        }
        $result = array(array());
        foreach ($a as $list) {
            $_tmp = array();
                foreach ($result as $result_item) {
                    foreach ($list as $list_item) {
                        $_tmp[] = array_merge($result_item, array($list_item));
                    }
                }
            if(array_sum($_tmp) <= $this->holes) {
                $result = $_tmp;
            }
        }
        return $result;
    }

    /**
     * draw possible pattern
     * @param  [array] pattern space map
     * @return [string]       pattern
     */
    private function drawPattern($step) {
        $pattern = "*";
        for($i=0; $i<count($step); $i++) {
            $pattern .= str_repeat("-", $step[$i]);
            $pattern .= "*";
        }
        return $pattern;
    }

    /**
     * draw possible combinations for pattern
     * @param  [string]  $pattern pattern
     * @param  integer $pointer   pointer
     * @return [array]           combinations
     */
    private function drawCombination ($pattern, $pointer = 0) {
        $empty_combination = str_repeat("-",$this->holes);
        $combinations = [];
        for($i = 0; $i < $this->holes; $i++) {
            if($pointer + strlen($pattern) > $this->holes) {
                return $combinations;
            }
            $combination = substr_replace($empty_combination, $pattern, $pointer, strlen($pattern));
            $combinations[] = $combination;
            $pointer++;
        }
        return false;
    }

    /**
     * display combinations to string for debugging
     * @param  [array] $data combinations
     * @return [void]
     */
    private function displayCombinations($data) {
        if(!empty($data)){
            foreach($data as $item) {
                echo $item."<br />";
            }
        }
    }

    /**
     * write combinations to a fle
     * @param  [array] $data combinations
     * @return [void]
     */
    private function writeToFile($data) {
        $fh = fopen($this->filename.".txt", 'w+') or die("can't open file");
        $content = "";
        if(count($data) < 10) {
            $content .= "Менее 10 вариантов";
        }
        else {
            $content .= "Количество вариантов: ". count($data);
        }
        foreach($data as $item) {
            $content .= "\r\n".$item;
        }
        fwrite($fh, $content);
        fclose($fh);
    }
}

