<?php
/**
* Branch With Fields Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/14
* @version 1.16.1114
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class BranchWithFieldsModel implements \JsonSerializable
{

    private $id = false;
    private $branch = false;
    private $fields = [];

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

    public function setFields($fields = false) {
        $this->fields = $fields;
    }
    public function getFields() {
        return $this->fields;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}
