<?php
/**
* Questions Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\QuestionsFactory;

class QuestionsService {

    private $factory;

    public function __construct()
    {
        $this->factory = new QuestionsFactory();
    }

    public function getQuestionList()
    {
        $list = [];
        try {
            $list = $this->factory->listAllOrderByQuestion();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getQuestionById($id = false)
    {
        $question = false;
        try {
            if ($id)
                $question = $this->factory->getById($id);
            if (isset($question->id) && $question->getId() == false)
                $question = false;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $question;
        }
    }

    public function delete($id)
    {
        try {
            $this->factory->deleteById($id);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        }
    }

    public function save($question)
    {
        try {
            if ($this->isQuestionValid($question)) {
                if ($question->getId() > 0) {
                    $this->factory->update($question);
                } else {
                    $question = $this->factory->insert($question);
                }
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $question;
        }
    }

    private function isQuestionValid($question)
    {
        if (!is_object($question)){
            return false;
        }
        if ($question->getStatusId() < 1){
            return false;
        }
        if (strlen($question->getQuestion()) < 1){
            return false;
        }
        if (strlen($question->getTutorText()) < 1){
            return false;
        }
        return true;
    }
}
