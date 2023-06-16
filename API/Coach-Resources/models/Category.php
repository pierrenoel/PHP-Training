<?php 

namespace core\models;

class Category 	{

    /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @return int
     */
    public function getId() : int
	 { 
		 return $this->id; 
	 }

    /**
     * @return string
     */
    public function getName() : string
	 { 
		 return $this->name; 
	 }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id) : self
	 { 
		 $this->id = $id; 

		 return $this->self; 
	 }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name) : self
	 { 
		 $this->name = $name; 

		 return $this->self; 
	 } 


}