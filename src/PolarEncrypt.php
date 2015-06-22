<?php
//A class to facilitate Polar Encryption
//Troy Daniels
//21/06/2115

class PolarEncrypt
{
    private $mapping;
    private $displacement;
    private $mapMin = 1;
    private $mapMax = 100;
    private $base = 8;
    private $mapCount = 0;

    public function __construct()
    {
        self::map();
    }

    //Sets a base and updates mapping
    public function setBase($newBase)
    {
        unset($this->mapping);
        $this->base=$newBase;
        self::map();
        self::displace();
    }

    public function getBase()
    {
        return $this->base;
    }

    public function setMapping(array $newMapping)
    {
        unset($this->mapping);
        $this->mapping=$newMapping;
    }

    public function getMapping()
    {
        return self::$mapping;
    }

    public function setMapCount($newCount)
    {
        $this->mapCount = $newCount;
    }

    public function getMapCount()
    {
        return $this-mapCount;
    }

    public function setDisplacement(array $displacement)
    {
        unset($this->displacement);
        $this->displacement = $displacement;
    }

    public function getDisplacement()
    {
        return $this->displacement;
    }

    //Takes a string and returns its polar encryption
    public function encrypt($stringIn)
    {
        $stringArray = str_split($stringIn);
        $encrypted = "";
        foreach($stringArray as $character){
            //Get character in base representation
            $radixRep = base_convert(ord($character), 10, $this->base);
            //Translate with mapping, add offset,  and add theta to encryption
            //Separate numbers by ' ' and finish lines with a '\n '
            foreach(str_split($radixRep) as $number) {
                 //Theta of the current mapCount-indexed intersection from mapping[]
                 $encrypted .= self::xToTheta($this->displacement[$this->mapCount], $this->mapping[$number]) . " ";
                 $this->mapCount=($this->mapCount+1) % count($this->displacement);
            }
            $encrypted .= "\n ";
        }
        return $encrypted;
    }

    public function decrypt($stringIn)
    {
        $stringArray = explode(" ", $stringIn);
        $decrypted = "";
        $unMapped = array();

        foreach($stringArray as $theta) {
            if($theta == "\n") {
                $baseRep = implode($unMapped);
                $decrypted .= chr(base_convert($baseRep, $this->base, 10));
                unset($unMapped);
            } else {
                $xValue=self::thetaToX($this->displacement[$this->mapCount], $theta);
                $unMapped[] = array_search($xValue, $this->mapping);
                $this->mapCount=($this->mapCount+1) % count($this->displacement);
            }
        }
        return $decrypted;
    }

    //Returns the n-th positive root of Fermat's spiral
    private function posFermatRoot($rootNum)
    {
        return (M_PI*$rootNum-M_PI/2);
    }

    //Takes theta from the origin, and returns the x-coordinate of the root whose perpendicular intersects
    // a line theta from the origin, at the k-th intersection with Fermat's spiral
    private function thetaToX($kValue, $theta)
    {
        $bestX=0;
        //Worst case
        $bestTheta=M_PI/2;
        //Test each number in mapping for intersections from ray. Closest is likely our number (rounding errors)
        foreach($this->mapping as $key=>$value) {
            $currentTheta = self::xToTheta($kValue, $value);
            if(abs($theta-$currentTheta) < abs($theta-$bestTheta)){
                $bestTheta = $currentTheta;
                $bestX = $value;
            }
        }
        return $bestX;
    }

    //Returns the polar angle from the origin of the k-th intersection of a line perpendicular to the n-th
    //positive root of Fermat's curve and Fermat's curve
    private function xToTheta($kValue, $nValue)
    {
        $root = self::posFermatRoot($nValue);

        //radius is given by the x-coordinate of the current root + k-times the distance between roots
        return acos($root/($root+2*M_PI*($kValue)));
    }

    //Finds a random mapping of numbers [0...base-1] to unique integers [mapMin...mapMax]
    private function map()
    {
        $randInt;
        $this->mapping = array();
        for($i=0; $i < $this->base; $i++) {
            do {
                //Use random_int() with PHP 7
                $randInt=rand($this->mapMin, $this->mapMax);
            } while(in_array($randInt, $this->mapping));
            //We now have a unique random number
            $this->mapping[$i]=$randInt;
        }
    }

    //Generates a random array of displacements, of length base^2 < l > base+1
    //with random displacements [1, l]
    private function displace()
    {
        $randInt;
        $elements = rand($this->base+1, $this->base*$this->base);
        $this->displacement = array();
        for($i=0; $i < $elements; $i++) {
            do {
                //Use random_int() with PHP 7
                $randInt=rand(1, $elements);
            } while(in_array($randInt, $this->displacement));
               //We now have a unique random number from [1,elements]
               $this->displacement[$i]=$randInt;
        }
    }

}

