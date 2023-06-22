<?php 

namespace app\models;

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
     * @var string
     */
    protected string $description;

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

		 return $this;
	 }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name) : self
	 { 
		 $this->name = $name; 

		 return $this;
	 }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}