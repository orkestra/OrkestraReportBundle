<?php

namespace Orkestra\Bundle\ReportBundle;

use Orkestra\Bundle\ReportBundle\Entity\Snapshot;

/**
 * Base class for any Report
 */
abstract class AbstractReport implements ReportInterface
{
    /**
     * Gathers data to use in creation of a new Snapshot
     *
     * @return array An associative array of facts
     */
    abstract protected function _gather();

    /**
     * Gets the class name of this report
     *
     * @return string
     */
    public function __toString()
    {
        return get_class($this);
    }

    /**
     * Creates a new Snapshot in time of this report
     *
     * @return Orkestra\Bundle\ReportBundle\Entity\Snapshot
     */
    public function createSnapshot()
    {
        return new Snapshot($this, $this->_gather());
    }
}
