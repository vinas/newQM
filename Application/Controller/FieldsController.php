<?php
/**
* Fields Controller Class
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

use Application\Model\FieldModel;
use Application\Service\FieldsService;
use Application\Service\ResponseHandlerService;

class FieldsController
{
    private $service;
    private $responseHandler;
    private $params;

    public function __construct($params)
    {
        $this->service = new FieldsService();
        $this->responseHandler = new ResponseHandlerService();
        $this->params = $params;
    }

    public function getList()
    {
        try {
            $fields = $this->service->getFieldList();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($fields, $res);
        }
    }

    public function getListWithBranch()
    {
        try {
            $fields = $this->service->getFieldListWithBranch();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($fields, $res);
        }
    }

    public function getFieldsByBranchId()
    {
        try {
            $fields = $this->service->getListByBranchId($this->params[0]);
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($fields, $res);
        }
    }

    public function get()
    {
        $field = false;
        try {
            $field = $this->service->getFieldById($this->params[0]);
            if ($field) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No field found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($field, $res);
        }
    }

    public function delete()
    {
        try {
            $this->service->delete($this->params[0]);
            $res = $this->responseHandler->handleInfoMessage('Field deleted.', 200);
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
            $field = Mapper::populate(new FieldModel(), $this->params);
            $field = $this->service->save($field);
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $field = false;
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($field, $res);
        }
    }
}
