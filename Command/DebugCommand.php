<?php

namespace Orkestra\Bundle\ReportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

/**
 * Displays a list of reports which are registered and tagged as such
 */
class DebugCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('reports:debug')
             ->setDescription('Displays all registered reports');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Available reports:</comment>');

        $maxAlias = 0;
        $maxClass = 0;

        $reports = $this->_getAvailableReports();

        foreach ($reports as $alias => $report) {
            $lenAlias = strlen($alias);
            $lenClass = strlen(get_class($report));

            $maxAlias = $maxAlias < $lenAlias ? $lenAlias : $maxAlias;
            $maxClass = $maxClass < $lenClass ? $lenClass : $maxClass;
        }

        $format = '%-' . $maxAlias . 's     %-' . $maxClass . 's';

        $output->writeln(sprintf('<info>%-' . $maxAlias . 's     %-' . $maxClass . 's</info>', 'Alias', 'Class'));

        foreach ($reports as $alias => $report) {
            $output->writeln(sprintf($format, $alias, get_class($report)));
        }

        $output->writeln(array(
            '',
            '<comment>Available presenters:</comment>'
        ));

        $maxAlias = 0;
        $maxClass = 0;

        $presenters = $this->_getAvailablePresenters();

        foreach ($presenters as $alias => $presenter) {
            $lenAlias = strlen($alias);
            $lenClass = strlen(get_class($presenter));

            $maxAlias = $maxAlias < $lenAlias ? $lenAlias : $maxAlias;
            $maxClass = $maxClass < $lenClass ? $lenClass : $maxClass;
        }

        $format = '%-' . $maxAlias . 's     %-' . $maxClass . 's';

        $output->writeln(sprintf('<info>%-' . $maxAlias . 's     %-' . $maxClass . 's</info>', 'Alias', 'Class'));

        foreach ($presenters as $alias => $presenter) {
            $output->writeln(sprintf($format, $alias, get_class($presenter)));
        }
    }

    /**
     * Gets an array of available reports
     *
     * @return array Key is the report alias, value is the report instance
     */
    protected function _getAvailableReports()
    {
        $factory = $this->getContainer()->get('orkestra.report_factory');

        return $factory->getReports();
    }

    /**
     * Gets an array of available presenters
     *
     * @return array Key is the presenter alias, value is the presenter instance
     */
    protected function _getAvailablePresenters()
    {
        $factory = $this->getContainer()->get('orkestra.report_factory');

        return $factory->getPresenters();
    }
}
