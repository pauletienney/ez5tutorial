<?php
/**
 * File containing the ObjectConverter interface.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Legacy\Templating\Converter;

/**
 * Interface for object converters.
 * The purpose of an object converter is to make objects compatible to eZ Publish legacy templates.
 */
interface ObjectConverter
{
    /**
     * Converts $object to make it compatible with eZTemplate API.
     *
     * @param object $object
     *
     * @throws \InvalidArgumentException If $object is actually not an object
     *
     * @return mixed|\eZ\Publish\Core\MVC\Legacy\Templating\LegacyCompatible
     */
    public function convert( $object );
}
