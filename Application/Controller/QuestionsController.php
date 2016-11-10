<?php
/**
* Questions Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/

namespace Application\Controller;

use SaSeed\Output\RestView;
use SaSeed\Handlers\Exceptions;
use SaSeed\Handlers\Mapper;

use Application\Model\QuestionModel;
use Application\Service\QuestionsService;
use Application\Service\ResponseHandlerService;

class QuestionsController
{
    private $service;
    private $responseHandler;
    private $params;

    public function __construct($params)
    {
        $this->service = new QuestionsService();
        $this->responseHandler = new ResponseHandlerService();
        $this->params = $params;
    }

    public function list()
    {
        try {
            $questions = $this->service->getQuestionList();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($questions, $res);
        }
    }

    public function get()
    {
        $question = false;
        try {
            $question = $this->service->getQuestionById($this->params[0]);
            if ($question) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No question found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($question, $res);
        }
    }

    public function delete()
    {
        try {
            $this->service->delete($this->params[0]);
            $res = $this->responseHandler->handleInfoMessage('Question deleted.', 200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render(false, $res);
        }
    }

    public function save()
    {
        try {
            $question = Mapper::populate(new QuestionModel(), $this->params);
            $question = $this->service->save($question);
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $question = false;
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($question, $res);
        }
    }
}
