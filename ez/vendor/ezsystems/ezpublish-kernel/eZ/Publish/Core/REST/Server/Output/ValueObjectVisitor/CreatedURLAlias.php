<?php
/**
 * File containing the CreatedURLAlias ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * CreatedURLAlias value object visitor
 */
class CreatedURLAlias extends URLAlias
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\CreatedURLAlias $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        parent::visit( $visitor, $generator, $data->urlAlias );
        $visitor->setHeader(
            'Location',
            $this->urlHandler->generate(
                'urlAlias',
                array( 'urlalias' => $data->urlAlias->id )
            )
        );
        $visitor->setStatus( 201 );
    }
}
