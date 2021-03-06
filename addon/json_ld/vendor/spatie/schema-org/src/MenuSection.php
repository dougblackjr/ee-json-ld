<?php

namespace Spatie\SchemaOrg;

/**
 * A sub-grouping of food or drink items in a menu. E.g. courses (such as
 * 'Dinner', 'Breakfast', etc.), specific type of dishes (such as 'Meat',
 * 'Vegan', 'Drinks', etc.), or some other classification made by the menu
 * provider.
 *
 * @see http://schema.org/MenuSection
 */
class MenuSection extends CreativeWork
{
    /**
     * A food or drink item contained in a menu or menu section.
     *
     * @param \Spatie\SchemaOrg\MenuSection $hasMenuItem
     *
     * @return static
     *
     * @see http://schema.org/hasMenuItem
     */
    public function hasMenuItem($hasMenuItem)
    {
        return $this->setProperty('hasMenuItem', $hasMenuItem);
    }
    /**
     * A subgrouping of the menu (by dishes, course, serving time period, etc.).
     *
     * @param \Spatie\SchemaOrg\MenuSection $hasMenuSection
     *
     * @return static
     *
     * @see http://schema.org/hasMenuSection
     */
    public function hasMenuSection($hasMenuSection)
    {
        return $this->setProperty('hasMenuSection', $hasMenuSection);
    }
}