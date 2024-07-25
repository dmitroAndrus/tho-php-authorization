<?php

/**
 * This file contains UserPhone class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\User;

use ThoPHPAuthorization\Data\ID\HasIDInterface;
use ThoPHPAuthorization\Data\ID\OnceIDTrait;
use ThoPHPAuthorization\Data\User\HasUserInterface;
use ThoPHPAuthorization\Data\User\UserTrait;
use ThoPHPAuthorization\Data\Phone\Phone;

/**
 * UserPhone is a class to manipulate user phone data.
 *
 * Provides access to phone and phone type data.
 *
 * Possible phone types: mobile, fax, work phone, etc.
 */
class UserPhone extends Phone implements HasIDInterface, HasUserInterface
{
    use OnceIDTrait;
    use UserTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // Set ID.
        if (isset($data['id']) && !empty($data['id'])) {
            $this->setID($data['id']);
        }
        // Set user.
        if (isset($data['user']) && !empty($data['user'])) {
            $this->setUser($data['user']);
        }
    }
}
