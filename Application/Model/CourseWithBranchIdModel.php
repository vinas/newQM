<?php
/**
* Course With Branch Id Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/18
* @version 1.16.1118
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class CourseWithBranchIdModel implements \JsonSerializable
{

    private $id;
    private $branchId;
    private $fieldId;
    private $level;
    private $course;
    private $isActive;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setFieldId($fieldId = false) {
        $this->fieldId = $fieldId;
    }
    public function getFieldId() {
        return $this->fieldId;
    }

    public function setBranchId($branchId = false) {
        $this->branchId = $branchId;
    }
    public function getBranchId() {
        return $this->branchId;
    }

    public function setLevel($level = false) {
        $this->level = $level;
    }
    public function getLevel() {
        return $this->level;
    }

    public function setCourse($course = false) {
        $this->course = $course;
    }
    public function getCourse() {
        return $this->course;
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
