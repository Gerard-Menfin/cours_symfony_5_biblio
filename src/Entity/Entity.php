<?php 

namespace App\Entity;

class Entity {
    public function fromArray(array $data): self {
        foreach ($data as $property => $value) {
            $setter = "set" . ucfirst($property);
            if(method_exists($this, $setter)) $this->$setter($value);
        }
        return $this;
    }
    
    public function __toString()
    {
        $className = get_called_class();                            // $className = "App\Entity\Livre"
        $className = str_replace("App\Entity\\", "", $className);   // $className = "Livre"
        $className = strtolower($className);                        // $className = "livre"
        return $className;
    }    
}