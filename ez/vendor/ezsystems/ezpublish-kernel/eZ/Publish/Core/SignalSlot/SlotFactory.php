<?php
/**
 * File containing the SignalDispatcher class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot;

/**
 * Fetches (creates) Slots by their identifier
 *
 * @internal
 */
abstract class SlotFactory
{
    /**
     * Returns a Slot with the given $slotIdentifier
     *
     * @param string $slotIdentifier
     *
     * @throws \eZ\Publish\Core\Base\Exceptions\NotFoundException When no slot is found
     *
     * @return \eZ\Publish\Core\SignalSlot\Slot
     */
    abstract public function getSlot( $slotIdentifier );
}
