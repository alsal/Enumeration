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
     * @var string
     */
    private $option;
    
    /**
     * @var integer
     */
    private $value;
    
    /**
     * @var array
     */
    private $options = array();
    
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
      	
        $this->options = $this->ref->getConstants();
        
        if (count($this->options) < 1) {
        	throw new Exception('No values in '. $this->ref->getName());
        }
      	
        $i = $option_or_value;
        if(is_numeric($i)){       
            $option = array_search($i, $this->options);
            if(isset($this->options[$option])) {
                $this->option = $option;
                $this->value = $this->options[$option];
            } else {
                throw new Exception('Invalid '.$this->ref->getName());
            }
        } else {//if(is_string($i)){
        	$i = strtoupper($i);
            if(isset($this->options[$i])){
                $this->option = $i;
                $this->value = $this->options[$i];
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
        return $this->value;
    }
    
    /**
     * More flexible comparison
     * 
     * @param mixed $Enum
     * @return boolean
     */
    public function compareTo($Enum){
        if(is_int($Enum))
            return ($this->value === $Enum);
        elseif($Enum instanceof self)
            return ($this->value === $Enum->getValue());
        else
            throw new Exception('Invalid input!');
    }
    
    /**
     * Returns an array of Enum Values
     *
     * @return array
     */
    public function getOptions(){
    	return $this->options;
    }
    
    public function getOption(){
    	return $this->option;
    }
    
    /**
     * Handy function to use enum class as string
     * 
     * @return string
     */
    public function __toString(){
        return strtolower($this->option);
    }
   
}