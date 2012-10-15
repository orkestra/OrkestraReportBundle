<?php

namespace Orkestra\Bundle\ReportBundle\Model;

/**
 * Defines the contract any Snapshot must follow
 */
interface SnapshotInterface
{
    /**
     * Gets the name of the associated report
     *
     * @return string
     */
    public function getReport();

    /**
     * Gets the associative array of facts associated with this snapshot
     *
     * @return array
     */
    public function getFacts();

    /**
     * Gets a single fact by its key
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getFact($name);
}
