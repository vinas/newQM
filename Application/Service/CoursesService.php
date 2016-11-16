<?php
/**
* Courses Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\CoursesFactory;

class CoursesService {

    private $factory;

    public function __construct()
    {
        $this->factory = new CoursesFactory();
    }

    public function getCourseList()
    {
        $list = [];
        try {
            $list = $this->factory->listAllOrderByCourse();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getListWithAll()
    {
        $list = [];
        try {
            $list = $this->factory->listWithAllOrderByCourse();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getCourseById($id = false)
    {
        $course = false;
        try {
            if ($id)
                $course = $this->factory->getById($id);
            if (isset($course->id) && $course->getId() == false)
                $course = false;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $course;
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

    public function save($course)
    {
        try {
            if ($this->isCourseValid($course)) {
                if ($course->getId() > 0) {
                    $this->factory->update($course);
                } else {
                    $course = $this->factory->insert($course);
                }
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $course;
        }
    }

    private function isCourseValid($course)
    {
        if (!is_object($course)){
            return false;
        }
        if ($course->getFieldId() < 1){
            return false;
        }
        if ($course->getLevel() < 1){
            return false;
        }
        if (strlen($course->getCourse()) < 1){
            return false;
        }
        return true;
    }
}
