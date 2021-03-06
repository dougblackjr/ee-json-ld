<?php

namespace Spatie\SchemaOrg;

/**
 * A technical article - Example: How-to (task) topics, step-by-step, procedural
 * troubleshooting, specifications, etc.
 *
 * @see http://schema.org/TechArticle
 */
class TechArticle extends Article
{
    /**
     * Prerequisites needed to fulfill steps in article.
     *
     * @param string $dependencies
     *
     * @return static
     *
     * @see http://schema.org/dependencies
     */
    public function dependencies($dependencies)
    {
        return $this->setProperty('dependencies', $dependencies);
    }
    /**
     * Proficiency needed for this content; expected values: 'Beginner',
     * 'Expert'.
     *
     * @param string $proficiencyLevel
     *
     * @return static
     *
     * @see http://schema.org/proficiencyLevel
     */
    public function proficiencyLevel($proficiencyLevel)
    {
        return $this->setProperty('proficiencyLevel', $proficiencyLevel);
    }
}