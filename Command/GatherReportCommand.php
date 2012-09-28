<?php

namespace Orkestra\Bundle\ReportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

/**
 * Creates a snapshot of a report
 */
class GatherReportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('reports:gather')
             ->addArgument('report', InputArgument::REQUIRED, 'The report to generate a snapshot for')
             ->setDescription('Gathers data for a specified report and creates a new snapshot.')
             ->setHelp('The <info>reports:gather</info> command will gather information for a report and create
a snapshot that represents the specified report at the given time.

This command is mainly intended to be run as a job or other scheduling system
such as <comment>crontab</comment>.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = $this->getContainer()->get('orkestra.report_factory');

        $report = $factory->getReport($input->getArgument('report'));

        $snapshot = $report->createSnapshot();

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->persist($snapshot);
        $em->flush();
    }
}
