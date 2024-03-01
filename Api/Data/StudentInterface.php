<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Api\Data;

interface StudentInterface
{

    const STU_NAME = 'stu_name';
    const STUDENT_ID = 'student_id';
    const STU_EMAIL = 'stu_email';

    /**
     * Get student_id
     * @return string|null
     */
    public function getStudentId();

    /**
     * Set student_id
     * @param string $studentId
     * @return \Bluethinkinc\QueueLearning\Student\Api\Data\StudentInterface
     */
    public function setStudentId($studentId);

    /**
     * Get stu_name
     * @return string|null
     */
    public function getStuName();

    /**
     * Set stu_name
     * @param string $stuName
     * @return \Bluethinkinc\QueueLearning\Student\Api\Data\StudentInterface
     */
    public function setStuName($stuName);

    /**
     * Get stu_email
     * @return string|null
     */
    public function getStuEmail();

    /**
     * Set stu_email
     * @param string $stuEmail
     * @return \Bluethinkinc\QueueLearning\Student\Api\Data\StudentInterface
     */
    public function setStuEmail($stuEmail);
}

