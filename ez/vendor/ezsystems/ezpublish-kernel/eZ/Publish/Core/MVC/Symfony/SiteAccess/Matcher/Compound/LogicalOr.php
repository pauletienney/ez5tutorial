<?php
/**
 * File containing the LogicalAnd compound siteaccess matcher class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher\Compound;

use eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher\Compound;

/**
 * Siteaccess matcher that allows a combination of matchers, with a logical OR
 */
class LogicalOr extends Compound
{
    const NAME = 'logicalOr';

    /**
     * @inheritDoc
     */
    public function match()
    {
        foreach ( $this->matchersMap as $subMatcher )
        {
            // It's a logical OR, so first matched => return configured siteaccess name
            if ( $subMatcher->match() )
            {
                return $this->siteaccessName;
            }
        }

        return false;
    }
}
