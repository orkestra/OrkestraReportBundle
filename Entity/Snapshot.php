<?php

namespace Orkestra\Bundle\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Orkestra\Common\Entity\EntityBase;

use Orkestra\Bundle\ReportBundle\ReportInterface;

/**
 * Represents a snapshot of a report at a given time
 *
 * @ORM\Table(name="orkestra_snapshots")
 * @ORM\Entity
 */
class Snapshot extends EntityBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="report", type="string")
     */
    protected $report;

    /**
     * @var array
     *
     * @ORM\Column(name="facts", type="array")
     */
    protected $facts;

    /**
     * Constructor
     *
     * @param Orkestra\Bundle\ReportBundle\IReport $report
     * @param array $facts An associative array of facts
     */
    public function __construct(ReportInterface $report, array $facts = array())
    {
        $this->report = $report->getName();
        $this->facts = $facts;
    }

    /**
     * Gets the name of the associated report
     *
     * @return string
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Gets the associative array of facts associated with this snapshot
     *
     * @return array
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
     * Gets a single fact by its key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getFact($name)
    {
        return array_key_exists($name, $this->facts) ? $this->facts[$name] : null;
    }
}
