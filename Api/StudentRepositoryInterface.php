<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface StudentRepositoryInterface
{

    /**
     * Save Student
     * @param \Bluethinkinc\QueueLearning\Api\Data\StudentInterface $student
     * @return \Bluethinkinc\QueueLearning\Api\Data\StudentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Bluethinkinc\QueueLearning\Api\Data\StudentInterface $student
    );

    /**
     * Retrieve Student
     * @param string $studentId
     * @return \Bluethinkinc\QueueLearning\Api\Data\StudentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($studentId);

    /**
     * Retrieve Student matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bluethinkinc\QueueLearning\Api\Data\StudentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Student
     * @param \Bluethinkinc\QueueLearning\Api\Data\StudentInterface $student
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Bluethinkinc\QueueLearning\Api\Data\StudentInterface $student
    );

    /**
     * Delete Student by ID
     * @param string $studentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($studentId);
}

