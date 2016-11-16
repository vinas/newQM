<?php
/**
* Field Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/16
* @version 1.16.1116
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class FieldWithBranchModel implements \JsonSerializable
{

    private $id;
    private $branch;
    private $field;
    private $isActive;

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

    public function setField($field = false) {
        $this->field = $field;
    }
    public function getField() {
        return $this->field;
    }

    public function setIsActive($isActive = false) {
        $this->isActive = $isActive;
    }
    public function getIsActive() {
        return $this->isActive;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}
