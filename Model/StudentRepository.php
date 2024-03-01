<?php
/**
 * Copyright © QueueLearning All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Model;

use Bluethinkinc\QueueLearning\Api\Data\StudentInterface;
use Bluethinkinc\QueueLearning\Api\Data\StudentInterfaceFactory;
use Bluethinkinc\QueueLearning\Api\Data\StudentSearchResultsInterfaceFactory;
use Bluethinkinc\QueueLearning\Api\StudentRepositoryInterface;
use Bluethinkinc\QueueLearning\Model\ResourceModel\Student as ResourceStudent;
use Bluethinkinc\QueueLearning\Model\ResourceModel\Student\CollectionFactory as StudentCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class StudentRepository implements StudentRepositoryInterface
{

    /**
     * @var StudentInterfaceFactory
     */
    protected $studentFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var Student
     */
    protected $searchResultsFactory;

    /**
     * @var StudentCollectionFactory
     */
    protected $studentCollectionFactory;

    /**
     * @var ResourceStudent
     */
    protected $resource;


    /**
     * @param ResourceStudent $resource
     * @param StudentInterfaceFactory $studentFactory
     * @param StudentCollectionFactory $studentCollectionFactory
     * @param StudentSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceStudent $resource,
        StudentInterfaceFactory $studentFactory,
        StudentCollectionFactory $studentCollectionFactory,
        StudentSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->studentFactory = $studentFactory;
        $this->studentCollectionFactory = $studentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(StudentInterface $student)
    {
        try {
            $this->resource->save($student);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the student: %1',
                $exception->getMessage()
            ));
        }
        return $student;
    }

    /**
     * @inheritDoc
     */
    public function get($studentId)
    {
        $student = $this->studentFactory->create();
        $this->resource->load($student, $studentId);
        if (!$student->getId()) {
            throw new NoSuchEntityException(__('Student with id "%1" does not exist.', $studentId));
        }
        return $student;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->studentCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(StudentInterface $student)
    {
        try {
            $studentModel = $this->studentFactory->create();
            $this->resource->load($studentModel, $student->getStudentId());
            $this->resource->delete($studentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Student: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($studentId)
    {
        return $this->delete($this->get($studentId));
    }
}

