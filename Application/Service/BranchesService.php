<?php
/**
* Branches Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\BranchesFactory;

class BranchesService {

    private $factory;

    public function __construct()
    {
        $this->factory = new BranchesFactory();
    }

    public function getBranchList()
    {
        $list = [];
        try {
            $list = $this->factory->listAllOrderByBranch();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function getBranchById($id = false)
    {
        $branch = false;
        try {
            if ($id)
                $branch = $this->factory->getById($id);
            if (isset($branch->id) && $branch->getId() == false)
                $branch = false;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $branch;
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

    public function save($branch)
    {
        try {
            if ($this->isBranchValid($branch)) {
                if ($branch->getId() > 0) {
                    $this->factory->update($branch);
                } else {
                    $branch = $this->factory->insert($branch);
                }
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $branch;
        }
    }

    private function isBranchValid($branch)
    {
        if (!is_object($branch)){
            return false;
        }
        if (strlen($branch->getBranch()) < 1){
            return false;
        }
        return true;
    }
}
