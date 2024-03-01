<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Api;

interface StudentInterfaceManagementInterface
{

    /**
     * GET for StudentInterface api
     * @param string $param
     * @return string
     */
    public function getStudentInterface($param);
}

