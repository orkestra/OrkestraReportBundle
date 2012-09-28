<?php

namespace Orkestra\Bundle\ReportBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Orkestra\Bundle\ReportBundle\DependencyInjection\Compiler\RegisterPresentersAndReportsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\DBAL\Types\Type;
use Orkestra\Common\Type\Date;
use Orkestra\Common\Type\DateTime;

class OrkestraReportBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterPresentersAndReportsPass());
    }
}
