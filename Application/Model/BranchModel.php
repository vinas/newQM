<?php
/**
* Branch Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/26
* @version 1.16.1110
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class BranchModel implements \JsonSerializable
{

    private $id;
    private $branch;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setBranch($branch = false) {
        $this->branch = $branch;
    }
    public function getBranch() {
        return $this->branch;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}
