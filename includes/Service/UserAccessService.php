<?php

/**
 * This file contains UserAccessService class.
 * PHP version 7.4
 *
 * @category Service
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

use ThoPHPAuthorization\Source\UserAccessSourceInterface;
use ThoPHPAuthorization\Source\UserRequestSourceInterface;
use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\Data\User\UserRequestInterface;
use ThoPHPAuthorization\Data\User\UserForgotPasswordRequest;

/**
 * UserAccessService is a class, that contains functionality to work with user access requests.
 */
class UserAccessService
{
    /**
     * Source to get users from.
     *
     * @var UserSourceInterface
     */
    protected $accessSource;

    /**
     * User forgot password request duration.
     *
     * How it works depends on the $accessSource.
     *
     * @var string|null
     */
    public static $forgotPasswordDuration = '+1 month';

    /**
     * Constructor.
     *
     * @param UserAccessSourceInterface $source Source to get users.
     *
     * @return void
     */
    public function __construct(UserAccessSourceInterface $source)
    {
        $this->accessSource = $source;
    }

    /**
     * Create forgot password access request.
     *
     * @param UserInterface $user User to create forgot password request for.
     *
     * @return UserRequestInterface
     */
    public function createForgotPasswordRequest(UserInterface $user)
    {
        $request = $this->accessSource->create($user, [
            'type' => UserForgotPasswordRequest::TYPE,
            'created' => new \DateTime(),
            'valid_until' => strtotime(static::$forgotPasswordDuration, time())
        ]);
        if ($request && ($this->accessSource instanceof UserRequestSourceInterface)) {
            $this->accessSource->store($request);
        }
        return $request;
    }

    /**
     * Resolve user request.
     *
     * @param UserRequestInterface $request Request to resolve.
     * @param mixed $data Necessary data to resolve request.
     *
     * @return boolean
     */
    public function resolveRequest(UserRequestInterface $request, $data = null)
    {
        $result = $this->accessSource->resolve($request, $data);
        if ($result) {
            $this->remove($request);
        }
        return $result;
    }

    /**
     * Get user request by security key.
     *
     * @param string $security Security key.
     *
     * @return UserRequestInterface|null
     */
    public function getBySecurity($security)
    {
        return $this->accessSource->getBySecurity($security);
    }

    /**
     * Remove user request by security key.
     *
     * @param string $security Security key.
     *
     * @return boolean Remove successful or not.
     */
    public function remove($request)
    {
        if ($this->accessSource instanceof UserRequestSourceInterface) {
            if (!($request instanceof UserRequestInterface)) {
                $request = $this->accessSource->getBySecurity($security);
            }
            if ($request) {
                return $this->accessSource->remove($request);
            }
            return true;
        }
        return false;
    }

    /**
     * Remove all expired requests.
     *
     * @return self
     */
    public function removeExpired()
    {
        if ($this->accessSource instanceof UserRequestSourceInterface) {
            $this->accessSource->removeExpired();
        }
        return $this;
    }
}
