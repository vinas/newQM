<?php
/**
* Courses Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/10
* @version 1.16.1110
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\CourseModel;
use Application\Model\CourseWithAllModel;

class CoursesFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'courses';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function listAllOrderByCourse()
    {
        $courses = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->orderBy('course');
            $courses = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($courses); $i++) {
                $courses[$i] = Mapper::populate(
                        new CourseModel(),
                        $courses[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $courses;
        }
    }

    public function listWithAllOrderByCourse()
    {
        $courses = [];
        try {
            $this->queryBuilder->rawSelect('c.id, c.course, c.level, c.isActive, f.field, b.branch, COUNT( qc.id ) AS questions');
            $this->queryBuilder->rawFrom('courses AS c JOIN fields AS f ON (c.fieldId = f.id) JOIN branches AS b ON (f.branchId = b.id) LEFT JOIN courseQuestion AS qc ON (c.id = qc.courseId)');
            $this->queryBuilder->rawWhere("1 GROUP BY c.id ORDER BY c.course");
            $courses = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($courses); $i++) {
                $courses[$i] = Mapper::populate(
                        new CourseWithAllModel(),
                        $courses[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $courses;
        }
    }

    public function getById($id = false)
    {
        $course = new CourseModel();
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where([
                    'id',
                    '=',
                    $id,
                    $this->queryBuilder->getMainTableAlias()
                ]);
            $course = Mapper::populate(
                    $course,
                    $this->db->getRow($this->queryBuilder->getQuery())
                );
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $course;
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

    public function insert($course)
    {
        try {
            $this->db->insertRow(
                $this->table,
                Array (
                    $course->getFieldId(),
                    $course->getLevel(),
                    $course->getCourse(),
                    $course->getIsActive()
                )
            );
            $course->setId($this->db->lastId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $course;
        }
    }

    public function update($course)
    {
        $res = false;
        try {
            if (!$course->getId()) {
                Exceptions::throwNew(
                    __CLASS__,
                    __FUNCTION__,
                    'No course Id informed.'
                );
                return false;
            }
            $this->db->update(
                $this->table,
                Array (
                    $course->getFieldId(),
                    $course->getLevel(),
                    $course->getCourse(),
                    $course->getIsActive()
                ),
                Array (
                    'fieldId',
                    'level',
                    'course',
                    'isActive'
                ),
                ['id', '=', $course->getId()]
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
