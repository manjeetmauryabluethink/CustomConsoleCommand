<?php

declare(strict_types=1);

namespace Bluethinkinc\QueueLearning\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bluethinkinc\QueueLearning\Model\StudentFactory;

class ConsoleCommand extends Command
{
    private const NAME = 'studentId';

      /**
     * @var StudentFactory
     */
    private $studentFactory;

    public function __construct(
        StudentFactory $studentFactory
    ) {
        $this->studentFactory = $studentFactory;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('delete:command');
        $this->setDescription('This is my first console command.');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'StudentId'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $exitCode = 0;
            $studentArray = '';
            $isExistsStudentId = [];
            $notExistsStudentId = [];
            if ($name = $input->getOption(self::NAME)) {
                $studentArray = explode(',', $name);
                foreach ($studentArray as $student ) {
                    $model = $this->studentFactory->create()->load($student);
                    if (count($model->getData()) > 0) {
                        $isExistsStudentId[] = $student;
                        $model->delete();
                    } else {
                        $notExistsStudentId[] = $student;
                    }
                }
                if(!empty($isExistsStudentId)) {
                    $output->writeln('<info>Data deleted successfully '.implode(",",$isExistsStudentId). '</info>');
                }
                if(!empty($notExistsStudentId)) {

                    $output->writeln('<info>Provided id is not exists in the database '.implode(",",$notExistsStudentId). '</info>');
                }
            }
        } catch (LocalizedException $e) {
             $output->writeln(sprintf(
                '<error>%s</error>',
                "StudentId is required"
             ));
             $exitCode = 1;
        }
         
        return $exitCode;
    }
}
