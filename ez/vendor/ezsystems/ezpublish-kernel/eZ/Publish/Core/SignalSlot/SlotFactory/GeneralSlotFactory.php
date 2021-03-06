<?php
/**
 * File containing the GeneralSlotFactory class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\SlotFactory;

use eZ\Publish\Core\SignalSlot\SlotFactory;
use eZ\Publish\Core\Base\Exceptions\NotFoundException;

/**
 * Slot factory that is able to lookup slots based on identifier.
 *
 * @deprecated To be removed when unit test runs on Sf stack, and ContainerSlotFactory is used everywhere.
 */
class GeneralSlotFactory extends SlotFactory
{
    /**
     * @var \eZ\Publish\Core\SignalSlot\Slot[]
     */
    protected $slots = array();

    /**
     * @param \eZ\Publish\Core\SignalSlot\Slot[] $slots
     */
    public function __construct( array $slots = array() )
    {
        $this->slots = $slots;
    }

    /**
     * Returns a Slot with the given $slotIdentifier
     *
     * @param string $slotIdentifier
     *
     * @throws \eZ\Publish\Core\Base\Exceptions\NotFoundException When no slot is found
     *
     * @return \eZ\Publish\Core\SignalSlot\Slot
     */
    public function getSlot( $slotIdentifier )
    {
        if ( !isset( $this->slots[$slotIdentifier] ) )
            throw new NotFoundException( 'slot', $slotIdentifier );

        return $this->slots[$slotIdentifier];
    }
}
