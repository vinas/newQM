<?php
/**
* Fields Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\FieldModel;

class FieldsFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'fields';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function listAllOrderByField()
    {
        $fields = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->orderBy('field');
            $fields = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($fields); $i++) {
                $fields[$i] = Mapper::populate(
                        new FieldModel(),
                        $fields[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $fields;
        }
    }

    public function listAllByBranchIdOrderByField($branchId)
    {
        $fields = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where(['branchId', '=', $branchId]);
            $this->queryBuilder->orderBy('field');
            $fields = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($fields); $i++) {
                $fields[$i] = Mapper::populate(
                        new FieldModel(),
                        $fields[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $fields;
        }
    }

    public function getById($id = false)
    {
        $field = new FieldModel();
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where([
                    'id',
                    '=',
                    $id,
                    $this->queryBuilder->getMainTableAlias()
                ]);
            $field = Mapper::populate(
                    $field,
                    $this->db->getRow($this->queryBuilder->getQuery())
                );
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $field;
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

    public function insert($field)
    {
        try {
            $this->db->insertRow(
                $this->table,
                Array (
                    $field->getBranchId(),
                    $field->getField(),
                    $field->getIsActive()
                )
            );
            $field->setId($this->db->lastId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $field;
        }
    }

    public function update($field)
    {
        $res = false;
        try {
            if (!$field->getId()) {
                Exceptions::throwNew(
                    __CLASS__,
                    __FUNCTION__,
                    'No field Id informed.'
                );
                return false;
            }
            $this->db->update(
                $this->table,
                Array (
                    $field->getBranchId(),
                    $field->getField(),
                    $field->getIsActive()
                ),
                Array (
                    'branchId',
                    'field',
                    'isActive'
                ),
                ['id', '=', $field->getId()]
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
