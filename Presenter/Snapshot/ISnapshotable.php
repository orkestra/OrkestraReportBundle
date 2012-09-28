<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\Snapshot;

/**
 * Defines the contract that a report must follow to support the SnapshotPresenter
 */
interface ISnapshotable
{
	/**
	 * Gets configuration options used specifically by the SnapshotPresenter
	 *
	 * @return Orkestra\Bundle\ReportBundle\Presenter\Snapshot\SnapshotOptions
	 */
	function getSnapshotOptions();
}
