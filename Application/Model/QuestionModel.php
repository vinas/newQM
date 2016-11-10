<?php
/**
* Question Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/26
* @version 1.16.1110
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class QuestionModel implements \JsonSerializable
{

    private $id;
    private $statusId;
    private $question;
    private $tutorText;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setStatusId($statusId = false) {
        $this->statusId = $statusId;
    }
    public function getStatusId() {
        return $this->statusId;
    }

    public function setQuestion($question = false) {
        $this->question = $question;
    }
    public function getQuestion() {
        return $this->question;
    }

    public function setTutorText($tutorText = false) {
        $this->tutorText = $tutorText;
    }
    public function getTutorText() {
        return $this->tutorText;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}
