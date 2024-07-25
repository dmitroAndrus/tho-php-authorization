<?php

/**
 * This file contains UserRequestSourceInterface interface.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Source\UserAccessSourceInterface;
use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\Data\User\UserRequestInterface;

/**
 * UserRequestSourceInterface is an interface, it declares a possibility to work with user request.
 */
interface UserRequestSourceInterface extends UserAccessSourceInterface
{
    /**
     * Get user request by ID.
     *
     * @param mixed $id User request ID.
     *
     * @return UserRequestInterface|null
     */
    public function getByID($id);

    /**
     * Check if such user request exists.
     *
     * @param UserRequestInterface $request User request object.
     *
     * @return boolean User exists or not.
     */
    public function exists(UserRequestInterface &$request);

    /**
     * Store user request.
     *
     * @param UserRequestInterface $request User request object.
     * @param boolean $renew Renew user request object.
     *
     * @return boolean Storing successful or not.
     */
    public function store(UserRequestInterface &$request, $renew);

    /**
     * Edit user request.
     *
     * @param UserRequestInterface $request User request object.
     * @param array|null $data User request data.
     * @param boolean $renew Renew user request object.
     *
     * @return boolean Editing successful or not.
     */
    public function edit(UserRequestInterface &$request, $data = null, $renew = true);

    /**
     * Remove user request.
     *
     * @param UserRequestInterface|mixed $request User request object or request security key.
     *
     * @return boolean Remove successful or not.
     */
    public function remove($request);

    /**
     * Remove all expired requests.
     *
     * @return self
     */
    public function removeExpired();
}
