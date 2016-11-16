<?php
/**
* Fields Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\FieldsFactory;

class FieldsService {

    private $factory;

    public function __construct()
    {
        $this->factory = new FieldsFactory();
    }

    public function getFieldList()
    {
        $list = [];
        try {
            $list = $this->factory->listAllOrderByField();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getFieldListWithBranch()
    {
        $list = [];
        try {
            $list = $this->factory->listAllWithBranchOrderByField();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getListByBranchId($branchId = false)
    {
        $list = [];
        try {
            if ($branchId)
                $list = $this->factory->listAllByBranchIdOrderByField($branchId);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getFieldById($id = false)
    {
        $field = false;
        try {
            if ($id)
                $field = $this->factory->getById($id);
            if (isset($field->id) && $field->getId() == false)
                $field = false;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $field;
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

    public function save($field)
    {
        try {
            if ($this->isFieldValid($field)) {
                if ($field->getId() > 0) {
                    $this->factory->update($field);
                } else {
                    $field = $this->factory->insert($field);
                }
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $field;
        }
    }

    private function isFieldValid($field)
    {
        if (!is_object($field)){
            return false;
        }
        if ($field->getBranchId() < 1){
            return false;
        }
        if (strlen($field->getField()) < 1){
            return false;
        }
        return true;
    }
}
