<?php
/**
* Course With All Info Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/26
* @version 1.16.1110
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class CourseWithAllModel implements \JsonSerializable
{

    private $id;
    private $branch;
    private $field;
    private $level;
    private $course;
    private $questions;
    private $isActive;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setLevel($level = false) {
        $this->level = $level;
    }
    public function getLevel() {
        return $this->level;
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

    public function setCourse($course = false) {
        $this->course = $course;
    }
    public function getCourse() {
        return $this->course;
    }

    public function setQuestions($questions = false) {
        $this->questions = $questions;
    }
    public function getQuestions() {
        return $this->questions;
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
