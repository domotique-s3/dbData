<?php

namespace DS3\Framework\PDO;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use DS3\Framework\Filesystem\File;

class FilePDOCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ds3:database:configure')
            ->setDescription('Creates a new pdo.cfg file')
            ->addOption(
                'path',
                'p',
                InputOption::VALUE_OPTIONAL,
                'The path to the generated configuration file',
                './app/pdo.cfg'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = new File($input->hasOption('path') ? $input->getOption('path'): './app/pdo.cfg');

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            'Please select your database driver',
            array('pgsql', 'mysql')
        );
        $driver = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the name of your database : ');
        $database = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the host of the database [localhost] : ', 'localhost');
        $host = $helper->ask($input, $output, $question);

        $question = new Question('Please enter your username : ', '');
        $username = $helper->ask($input, $output, $question);

        $question = new Question('Please enter your password (value hidden) : ', '');
        $question->setHidden(true);
        $question->setHiddenFallback(true);
        $pass = $helper->ask($input, $output, $question);

        $file->clear();

        $file->write($driver . PHP_EOL);
        $file->write($database . PHP_EOL);
        $file->write($host . PHP_EOL);
        $file->write($username . PHP_EOL);
        $file->write($pass . PHP_EOL);
    }
}
