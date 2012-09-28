<?php

namespace Orkestra\Bundle\ReportBundle;

/**
 * Defines the contract all Presenters must follow
 *
 * A Presenter is essentially a slimmed down Controller in that it defines a
 * template (or view) to be used for rendering a given report and a set of
 * Filters to allow constraining the collection of Snapshots returned when
 * the Presenter is bound to a Presentation
 */
interface PresenterInterface
{
    /**
     * Gets the name of the Presenter
     *
     * The name is used internally by the ReportFactory. As such, it should be
     * unique across the entire application.
     *
     * @return string
     */
    function getName();

    /**
     * Gets the name of the template to be used when rendering this Presenter
     *
     * @return string
     */
    function getTemplate();

    /**
     * Gets an array of Filters available for this presenter
     *
     * @return array
     */
    function getFilters();

    /**
     * Checks to see if a Report implements the necessary methods for this Presenter
     * to function
     *
     * @return boolean
     */
    function supports(ReportInterface $report);
}
