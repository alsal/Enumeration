<?php
namespace alsal\enumeration;

use ReflectionClass;
use Exception;

/**
 * General Enumeration Utility class.
 * 
 * @author Alan Salgado
 *
 */
abstract class AbstractEnum {
	
    /**
     * @var mixed
     */
    private $constantName;
    
    /**
     * @var mixed
     */
    private $constantValue;
    
    /**
     * @var array
     */
    private $constants = array();
    
    /**
     *
     * @var ReflectionClass
     */
    protected $ref;
    
    /**
     * Constructor
     * @param string/int $option_or_value
     */
    function __construct($option_or_value) {
    	
      	$this->ref = new ReflectionClass($this);
      	
        $this->constants = $this->ref->getConstants();
        
        if (count($this->constants) < 1) {
        	throw new Exception('No values in '. $this->ref->getName());
        }
      	
        $i = $option_or_value;
        if(is_numeric($i)){       
            $option = array_search($i, $this->constants);
            if(isset($this->constants[$option])) {
                $this->constantName = $option;
                $this->constantValue = $this->constants[$option];
            } else {
                throw new Exception('Invalid '.$this->ref->getName());
            }
        } else {//if(is_string($i)){
        	$i = strtoupper($i);
            if(isset($this->constants[$i])){
                $this->constantName = $i;
                $this->constantValue = $this->constants[$i];
            } else {
                throw new Exception('Invalid '.$this->ref->getName());
            }
        }
    }
    
    /**
     * Proper comparison function for the class
     * 
     * @param AbstractEnum $Enum1
     * @param AbstractEnum $Enum2
     * 
     */
    public static function isEqual(AbstractEnum $Enum1, AbstractEnum $Enum2){
        return ($Enum1->getValue() === $Enum2->getValue());
    }
    
    public function getValue(){
        return $this->constantValue;
    }
    
    /**
     * More flexible comparison
     * 
     * @param mixed $Enum
     * @return boolean
     */
    public function compareTo($Enum){
        if(is_int($Enum))
            return ($this->constantValue === $Enum);
        elseif($Enum instanceof self)
            return ($this->constantValue === $Enum->getValue());
        else
            throw new Exception('Invalid input!');
    }
    
    /**
     * Returns an array of Enum Values
     *
     * @return array
     */
    public function getOptions(){
    	return $this->ref->getConstants();
    }
    
    public function getOption(){
    	return $this->constantName;
    }
    
    /**
     * Handy function to use enum class as string
     * 
     * @return string
     */
    public function __toString(){
        return strtolower($this->constantName);
    }
   
}