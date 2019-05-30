<?php

namespace App\Entity;

class CategorySearch
{
    /**
     * Undocumented variable
     *
     * @var float|null
     */
    private $price;


    /**
     * Undocumented variable
     *
     * @var string
     */
    private $name;

   

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $name  Undocumented variable
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  float|null
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set undocumented variable
     *
     * @param  float|null  $price  Undocumented variable
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}
