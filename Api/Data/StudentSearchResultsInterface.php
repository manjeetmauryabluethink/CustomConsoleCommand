<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Api\Data;

interface StudentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Student list.
     * @return \Bluethinkinc\QueueLearning\Api\Data\StudentInterface[]
     */
    public function getItems();

    /**
     * Set stu_name list.
     * @param \Bluethinkinc\QueueLearning\Api\Data\StudentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

