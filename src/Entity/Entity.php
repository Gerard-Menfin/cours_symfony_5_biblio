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
    
}