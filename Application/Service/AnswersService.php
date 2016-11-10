<?php
/**
* Answers Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\AnswersFactory;

class AnswersService {

    private $factory;

    public function __construct()
    {
        $this->factory = new AnswersFactory();
    }

    public function getAnswerList()
    {
        $list = [];
        try {
            $list = $this->factory->listAllOrderByAnswer();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getAnswerById($id = false)
    {
        $answer = false;
        try {
            if ($id)
                $answer = $this->factory->getById($id);
            if (isset($answer->id) && $answer->getId() == false)
                $answer = false;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $answer;
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

    public function save($answer)
    {
        try {
            if ($this->isAnswerValid($answer)) {
                if ($answer->getId() > 0) {
                    $this->factory->update($answer);
                } else {
                    $answer = $this->factory->insert($answer);
                }
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $answer;
        }
    }

    private function isAnswerValid($answer)
    {
        if (!is_object($answer)){
            return false;
        }
        if ($answer->getQuestionId() < 1){
            return false;
        }
        if (strlen($answer->getAnswer()) < 1){
            return false;
        }
        return true;
    }
}
