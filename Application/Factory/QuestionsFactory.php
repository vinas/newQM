<?php
/**
* Questions Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\QuestionModel;

class QuestionsFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'questions';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function listAllOrderByQuestion()
    {
        $questions = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->orderBy('question');
            $questions = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($questions); $i++) {
                $questions[$i] = Mapper::populate(
                        new QuestionModel(),
                        $questions[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $questions;
        }
    }

    public function getById($id = false)
    {
        $question = new QuestionModel();
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where([
                    'id',
                    '=',
                    $id,
                    $this->queryBuilder->getMainTableAlias()
                ]);
            $question = Mapper::populate(
                    $question,
                    $this->db->getRow($this->queryBuilder->getQuery())
                );
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $question;
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

    public function insert($question)
    {
        try {
            $this->db->insertRow(
                $this->table,
                Array (
                    $question->getStatusId(),
                    $question->getQuestion(),
                    $question->getTutorText()
                )
            );
            $question->setId($this->db->lastId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $question;
        }
    }

    public function update($question)
    {
        $res = false;
        try {
            if (!$question->getId()) {
                Exceptions::throwNew(
                    __CLASS__,
                    __FUNCTION__,
                    'No question Id informed.'
                );
                return false;
            }
            $this->db->update(
                $this->table,
                Array (
                    $question->getStatusId(),
                    $question->getQuestion(),
                    $question->getTutorText()
                ),
                Array (
                    'statusId',
                    'question',
                    'tutorText'
                ),
                ['id', '=', $question->getId()]
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
