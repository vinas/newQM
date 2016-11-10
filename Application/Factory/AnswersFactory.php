<?php
/**
* Answers Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\AnswerModel;

class AnswersFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'answers';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function listAllOrderByAnswer()
    {
        $answers = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->orderBy('answer');
            $answers = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($answers); $i++) {
                $answers[$i] = Mapper::populate(
                        new AnswerModel(),
                        $answers[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $answers;
        }
    }

    public function getById($id = false)
    {
        $answer = new AnswerModel();
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where([
                    'id',
                    '=',
                    $id,
                    $this->queryBuilder->getMainTableAlias()
                ]);
            $answer = Mapper::populate(
                    $answer,
                    $this->db->getRow($this->queryBuilder->getQuery())
                );
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $answer;
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

    public function insert($answer)
    {
        try {
            $this->db->insertRow(
                $this->table,
                Array (
                    $answer->getQuestionId(),
                    $answer->getAnswer(),
                    $answer->getIsCorrect()
                )
            );
            $answer->setId($this->db->lastId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $answer;
        }
    }

    public function update($answer)
    {
        $res = false;
        try {
            if (!$answer->getId()) {
                Exceptions::throwNew(
                    __CLASS__,
                    __FUNCTION__,
                    'No answer Id informed.'
                );
                return false;
            }
            $this->db->update(
                $this->table,
                Array (
                    $answer->getQuestionId(),
                    $answer->getAnswer(),
                    $answer->getIsCorrect()
                ),
                Array (
                    'questionId',
                    'answer',
                    'isCorrect'
                ),
                ['id', '=', $answer->getId()]
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
