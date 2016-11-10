<?php
/**
* Answer Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/26
* @version 1.16.1110
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class AnswerModel implements \JsonSerializable
{

    private $id;
    private $questionId;
    private $answer;
    private $isCorrect;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setQuestionId($questionId = false) {
        $this->questionId = $questionId;
    }
    public function getQuestionId() {
        return $this->questionId;
    }

    public function setAnswer($answer = false) {
        $this->answer = $answer;
    }
    public function getAnswer() {
        return $this->answer;
    }

    public function setIsCorrect($isCorrect = false) {
        $this->isCorrect = $isCorrect;
    }
    public function getIsCorrect() {
        return $this->isCorrect;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}
