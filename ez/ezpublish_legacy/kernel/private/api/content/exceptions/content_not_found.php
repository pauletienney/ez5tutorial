<?php
/**
 * File containing the ezpContentNotFoundException exception
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2013.1
 * @package kernel
 */

class ezpContentNotFoundException extends ezpContentException
{
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}

?>
