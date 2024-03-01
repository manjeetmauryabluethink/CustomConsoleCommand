<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Model;

use Bluethinkinc\QueueLearning\Api\Data\StudentInterface;
use Magento\Framework\Model\AbstractModel;

class Student extends AbstractModel implements StudentInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Bluethinkinc\QueueLearning\Model\ResourceModel\Student::class);
    }

    /**
     * @inheritDoc
     */
    public function getStudentId()
    {
        return $this->getData(self::STUDENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStudentId($studentId)
    {
        return $this->setData(self::STUDENT_ID, $studentId);
    }

    /**
     * @inheritDoc
     */
    public function getStuName()
    {
        return $this->getData(self::STU_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setStuName($stuName)
    {
        return $this->setData(self::STU_NAME, $stuName);
    }

    /**
     * @inheritDoc
     */
    public function getStuEmail()
    {
        return $this->getData(self::STU_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setStuEmail($stuEmail)
    {
        return $this->setData(self::STU_EMAIL, $stuEmail);
    }
}

