<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Limitation;

use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\API\Repository\Values\User\User as APIUser;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\LocationCreateStruct;
use eZ\Publish\Core\Base\Exceptions\BadStateException;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation as APIParentUserGroupLimitation;
use eZ\Publish\API\Repository\Values\User\Limitation as APILimitationValue;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\SPI\Limitation\Type as SPILimitationTypeInterface;
use eZ\Publish\SPI\Persistence\Handler as SPIPersistenceHandler;

/**
 * ParentUserGroupLimitation is a Content limitation
 */
class ParentUserGroupLimitationType implements SPILimitationTypeInterface
{
    /**
     * @var \eZ\Publish\SPI\Persistence\Handler
     */
    protected $persistence;

    /**
     * @param \eZ\Publish\SPI\Persistence\Handler $persistence
     */
    public function __construct( SPIPersistenceHandler $persistence )
    {
        $this->persistence = $persistence;
    }

    /**
     * Accepts a Limitation value
     *
     * Makes sure LimitationValue object is of correct type and that ->limitationValues
     * is valid according to valueSchema().
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $limitationValue
     *
     * @return boolean
     */
    public function acceptValue( APILimitationValue $limitationValue )
    {
        throw new \eZ\Publish\API\Repository\Exceptions\NotImplementedException( __METHOD__ );
    }

    /**
     * Create the Limitation Value
     *
     * @param mixed[] $limitationValues
     *
     * @return \eZ\Publish\API\Repository\Values\User\Limitation
     */
    public function buildValue( array $limitationValues )
    {
        return new APIParentUserGroupLimitation( array( 'limitationValues' => $limitationValues ) );
    }

    /**
     * Evaluate permission against content & target(placement/parent/assignment)
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If any of the arguments are invalid
     *         Example: If LimitationValue is instance of ContentTypeLimitationValue, and Type is SectionLimitationType.
     * @throws \eZ\Publish\API\Repository\Exceptions\BadStateException If value of the LimitationValue is unsupported
     *         Example if OwnerLimitationValue->limitationValues[0] is not one of: [ 1,  2 ]
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param \eZ\Publish\API\Repository\Values\User\User $currentUser
     * @param \eZ\Publish\API\Repository\Values\ValueObject $object
     * @param \eZ\Publish\API\Repository\Values\ValueObject|null $target The location, parent or "assignment" value object
     *
     * @return boolean
     */
    public function evaluate( APILimitationValue $value, APIUser $currentUser, ValueObject $object, ValueObject $target = null )
    {
        if ( !$value instanceof APIParentUserGroupLimitation )
            throw new InvalidArgumentException( '$value', 'Must be of type: APIParentUserGroupLimitation' );

        if ( $value->limitationValues[0] != 1 )
        {
            throw new BadStateException(
                'Parent User Group limitation',
                'expected limitation value to be 1 but got:' . $value->limitationValues[0]
            );
        }

        if ( $target instanceof LocationCreateStruct )
        {
            $spiLocation = $this->persistence->locationHandler()->load( $target->parentLocationId );
            $spiContentInfo = $this->persistence->contentHandler()->loadContentInfo( $spiLocation->contentId );
            $parentOwnerId = $spiContentInfo->ownerId;
        }
        else if ( $target !== null && !$target instanceof Location )
            throw new InvalidArgumentException( '$target', 'Must be of type: Location' );
        else if ( $target === null )
            return false;
        else // $target is assumed to be parent in this case
            $parentOwnerId = $target->getContentInfo()->ownerId;

        if ( $parentOwnerId === $currentUser->id )
            return true;

        /**
         * As long as SPI userHandler and API UserService does not speak the same language, this is the ugly truth;
         */
        $locationHandler = $this->persistence->locationHandler();
        $parentOwnerLocations = $locationHandler->loadLocationsByContent( $parentOwnerId );
        if ( empty( $parentOwnerLocations ) )
            return false;

        $currentUserLocations = $locationHandler->loadLocationsByContent( $currentUser->id );
        if ( empty( $currentUserLocations ) )
           return false;

        // @todo Needs to take care of inherited groups as well when UserHandler gets knowledge about user groups
        foreach ( $parentOwnerLocations as $parentOwnerLocation )
        {
            foreach ( $currentUserLocations as $currentUserLocation )
            {
                if ( $parentOwnerLocation->parentId === $currentUserLocation->parentId )
                    return true;
            }
        }

        return false;
    }

    /**
     * Returns Criterion for use in find() query
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param \eZ\Publish\API\Repository\Values\User\User $currentUser
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface
     */
    public function getCriterion( APILimitationValue $value, APIUser $currentUser )
    {
        throw new \eZ\Publish\API\Repository\Exceptions\NotImplementedException( __METHOD__ );
    }

    /**
     * Returns info on valid $limitationValues
     *
     * @return mixed[]|int In case of array, a hash with key as valid limitations value and value as human readable name
     *                     of that option, in case of int on of VALUE_SCHEMA_ constants.
     */
    public function valueSchema()
    {
        throw new \eZ\Publish\API\Repository\Exceptions\NotImplementedException( __METHOD__ );
    }
}
