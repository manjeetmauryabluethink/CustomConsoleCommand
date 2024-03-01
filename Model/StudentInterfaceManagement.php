<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Model;

class StudentInterfaceManagement implements \Bluethinkinc\QueueLearning\Api\StudentInterfaceManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getStudentInterface($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}

