<?php

namespace Spatie\SchemaOrg;

/**
 * A Report generated by governmental or non-governmental organization.
 *
 * @see http://schema.org/Report
 */
class Report extends Article
{
    /**
     * The number or other unique designator assigned to a Report by the
     * publishing organization.
     *
     * @param string $reportNumber
     *
     * @return static
     *
     * @see http://schema.org/reportNumber
     */
    public function reportNumber($reportNumber)
    {
        return $this->setProperty('reportNumber', $reportNumber);
    }
}