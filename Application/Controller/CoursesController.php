<?php
/**
* Courses Controller Class
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

use Application\Model\CourseModel;
use Application\Service\CoursesService;
use Application\Service\ResponseHandlerService;

class CoursesController
{
    private $service;
    private $responseHandler;
    private $params;

    public function __construct($params)
    {
        $this->service = new CoursesService();
        $this->responseHandler = new ResponseHandlerService();
        $this->params = $params;
    }

    public function getList()
    {
        try {
            $courses = $this->service->getCourseList();
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($courses, $res);
        }
    }

    public function getListWithAll()
    {
        try {
            $fields = $this->service->getListWithAll();
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
        $course = false;
        try {
            $course = $this->service->getById($this->params[0]);
            if ($course) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No course found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($course, $res);
        }
    }

    public function getWithBranchId()
    {
        $course = false;
        try {
            $course = $this->service->getWithBranchIdById($this->params[0]);
            if ($course) {
                $res = $this->responseHandler->handleCode(200);
            } else {
                $res = $this->responseHandler->handleWarningMessage('No course found.', 200);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($course, $res);
        }
    }

    public function delete()
    {
        try {
            $this->service->delete($this->params[0]);
            $res = $this->responseHandler->handleInfoMessage('Course deleted.', 200);
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
            $course = Mapper::populate(new CourseModel(), $this->params);
            $course = $this->service->save($course);
            $res = $this->responseHandler->handleCode(200);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $course = false;
            $res = $this->responseHandler->handleErrorMessage($e->getMessage());
        } finally {
            RestView::render($course, $res);
        }
    }
}
