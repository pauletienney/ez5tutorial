<?php
/**
 * File containing the SortClauseVisitor\LocationPathString class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Solr\Content\Search\SortClauseVisitor;

use eZ\Publish\Core\Persistence\Solr\Content\Search\SortClauseVisitor;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

/**
 * Visits the sortClause tree into a Solr query
 */
class LocationPathString extends SortClauseVisitor
{
    /**
     * CHeck if visitor is applicable to current sortClause
     *
     * @param SortClause $sortClause
     *
     * @return boolean
     */
    public function canVisit( SortClause $sortClause )
    {
        return $sortClause instanceof SortClause\LocationPathString;
    }

    /**
     * Map field value to a proper Solr representation
     *
     * @param SortClause $sortClause
     *
     * @return void
     */
    public function visit( SortClause $sortClause )
    {
        return 'path_id' . $this->getDirection( $sortClause );
    }
}

