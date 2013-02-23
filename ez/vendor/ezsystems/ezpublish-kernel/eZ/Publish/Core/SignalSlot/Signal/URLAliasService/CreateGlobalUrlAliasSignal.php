<?php
/**
 * CreateGlobalUrlAliasSignal class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\URLAliasService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * CreateGlobalUrlAliasSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\URLAliasService
 */
class CreateGlobalUrlAliasSignal extends Signal
{
    /**
     * URL Alias ID
     *
     * @var mixed
     */
    public $urlAliasId;
}
