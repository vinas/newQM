<?php
/**
* Branch Controller Class
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

use Application\Model\BranchModel;
use Application\Service\BranchesService;
use Application\Service\ResponseHandlerService;

class BranchesController
{
    private $service;
    private $responseHandler;
    private $params;

    public function __construct($params)
    {
        $this->service = new BranchesService();
        $this->responseHandler = new ResponseHandlerService();
        $this->params = $params;
    }

    public function getList()
    {
        try {
            $branches = $this->service->getList();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($branches, $res);
        }
    }

    public function getListWithCounters()
    {
        try {
            $branches = $this->service->getListWithCounters();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($branches, $res);
        }
    }

    public function get()
    {
        $branch = false;
        try {
            $branch = $this->service->getBranchById($this->params[0]);
            if ($branch) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No branch found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($branch, $res);
        }
    }

    public function getBranchWithFields()
    {
        $branch = false;
        try {
            $branch = $this->service->getBranchWithFields($this->params[0]);
            if ($branch) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No branch found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($branch, $res);
        }
    }

    public function delete()
    {
        try {
            $this->service->delete($this->params[0]);
            $res = $this->responseHandler->handleInfoMessage('Branch deleted.', 200);
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
            $branch = Mapper::populate(new BranchModel(), $this->params);
            $branch = $this->service->save($branch);
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $branch = false;
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($branch, $res);
        }
    }
}
