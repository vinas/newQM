<?php
/**
* Branch Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/11
* @version 1.16.1111
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class BranchWithCountersModel implements \JsonSerializable
{

    private $id;
    private $branch;
    private $fields;
    private $courses;

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

    public function setCourses($courses = false) {
        $this->courses = $courses;
    }
    public function getCourses() {
        return $this->courses;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}
