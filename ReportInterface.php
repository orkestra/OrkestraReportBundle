<?php

namespace Orkestra\Bundle\ReportBundle;

/**
 * Defines the contract any Report must follow
 */
interface ReportInterface
{
    /**
     * Gets the internally used name of the Report
     *
     * @return string
     */
    function getName();

    /**
     * Gets an array of facts defined on this Report
     *
     * @return array
     */
    function getFacts();

    /**
     * Gets a pretty label for the specified fact
     *
     * @return string
     */
    function getLabel($fact);

    /**
     * Creates a new Snapshot in time of this report
     *
     * @return Orkestra\Bundle\ReportBundle\Entity\Snapshot
     */
    function createSnapshot();
}
