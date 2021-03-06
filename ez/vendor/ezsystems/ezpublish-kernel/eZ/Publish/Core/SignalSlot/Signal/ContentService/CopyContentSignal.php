<?php
/**
 * CopyContentSignal class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\ContentService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * CopyContentSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\ContentService
 */
class CopyContentSignal extends Signal
{
    /**
     * Source Content ID
     *
     * @var mixed
     */
    public $srcContentId;

    /**
     * Source Version Number
     *
     * @var int|null
     */
    public $srcVersionNo;

    /**
     * Destination Content ID
     *
     * @var mixed
     */
    public $dstContentId;

    /**
     * Destination Version Number
     *
     * @var int
     */
    public $dstVersionNo;

    /**
     * Destination Parent Location ID
     *
     * @var mixed
     */
    public $dstParentLocationId;
}
