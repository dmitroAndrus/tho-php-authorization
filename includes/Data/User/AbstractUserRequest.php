<?php

/**
 * This file contains AbstractUserRequest class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\User;

use ThoPHPAuthorization\Data\User\UserRequestInterface;
use ThoPHPAuthorization\Data\ID\IDTrait;
use ThoPHPAuthorization\Data\User\UserTrait;
use ThoPHPAuthorization\Data\Password\SecurityKeyTrait;
use ThoPHPAuthorization\Data\DateTime\CreatedTrait;
use ThoPHPAuthorization\Data\DateTime\ValidUntilTrait;

/**
 * AbstractUserRequest is an abstract class that provides access to user requests.
 */
abstract class AbstractUserRequest implements UserRequestInterface
{
    use IDTrait;
    use UserTrait;
    use SecurityKeyTrait;
    use CreatedTrait;
    use ValidUntilTrait;

    /**
     * Constructor.
     *
     * @param array $data User request data.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $date_time_format = isset($data['date_time_format'])
            ? $data['date_time_format']
            : (isset($data['dateTimeFormat'])
                ? $data['dateTimeFormat']
                : null);
        // Set ID.
        if (isset($data['id']) && !empty($data['id'])) {
            $this->setID($data['id']);
        }
        // Set user.
        if (isset($data['user']) && !empty($data['user'])) {
            $this->setUser($data['user']);
        }
        // Set security key directly or password (convert to security key).
        if (isset($data['security']) && !empty($data['security'])) {
            $this->setSecurity($data['security']);
        }
        // Created.
        if (isset($data['created']) && !empty($data['created'])) {
            $this->setCreated(
                $data['created'],
                isset($data['created_format'])
                    ? $data['created_format']
                    : (isset($data['createdFormat'])
                        ? $data['createdFormat']
                        : $date_time_format)
            );
        }
        // Valid until.
        if (isset($data['valid_until']) && !empty($data['valid_until'])) {
            $this->setValidUntil(
                $data['valid_until'],
                isset($data['valid_until_format'])
                    ? $data['valid_until_format']
                    : (isset($data['validUntilFormat'])
                        ? $data['validUntilFormat']
                        : $date_time_format)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function expired()
    {
        $datetime = $this->getValidUntil();
        if (!$datetime) {
            return false;
        }
        $now = new \DateTime();
        return $datetime < $now;
    }
}
