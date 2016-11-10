<?php
/**
* Answers Controller Class
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

use Application\Model\AnswerModel;
use Application\Service\AnswersService;
use Application\Service\ResponseHandlerService;

class AnswersController
{
    private $service;
    private $responseHandler;
    private $params;

    public function __construct($params)
    {
        $this->service = new AnswersService();
        $this->responseHandler = new ResponseHandlerService();
        $this->params = $params;
    }

    public function getList()
    {
        try {
            $answers = $this->service->getAnswerList();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($answers, $res);
        }
    }

    public function get()
    {
        $answer = false;
        try {
            $answer = $this->service->getAnswerById($this->params[0]);
            if ($answer) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No answer found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($answer, $res);
        }
    }

    public function delete()
    {
        try {
            $this->service->delete($this->params[0]);
            $res = $this->responseHandler->handleInfoMessage('Answer deleted.', 200);
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
            $answer = Mapper::populate(new AnswerModel(), $this->params);
            $answer = $this->service->save($answer);
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $answer = false;
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($answer, $res);
        }
    }
}
