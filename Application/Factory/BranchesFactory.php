<?php
/**
* Branch Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\BranchModel;

class BranchesFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'branches';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function listAllOrderByBranch()
    {
        $branches = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->orderBy('branch');
            $branches = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($branches); $i++) {
                $branches[$i] = Mapper::populate(
                        new BranchModel(),
                        $branches[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $branches;
        }
    }

    public function getById($id = false)
    {
        $branch = new BranchModel();
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where([
                    'id',
                    '=',
                    $id,
                    $this->queryBuilder->getMainTableAlias()
                ]);
            $branch = Mapper::populate(
                    $branch,
                    $this->db->getRow($this->queryBuilder->getQuery())
                );
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $branch;
        }
    }

    public function deleteById($id)
    {
        try {
            $this->db->deleteRow($this->table, ['id', '=', $id]);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        }
    }

    public function insert($branch)
    {
        try {
            $this->db->insertRow(
                $this->table,
                [$branch->getBranch()]
            );
            $branch->setId($this->db->lastId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $branch;
        }
    }

    public function update($branch)
    {
        $res = false;
        try {
            if (!$branch->getId()) {
                Exceptions::throwNew(
                    __CLASS__,
                    __FUNCTION__,
                    'No branch Id informed.'
                );
                return false;
            }
            $this->db->update(
                $this->table,
                [$branch->getBranch()],
                ['branch'],
                ['id', '=', $branch->getId()]
            );
            $res = true;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            $res = false;
        } finally {
            return $res;
        }
    }
}

