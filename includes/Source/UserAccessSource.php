<?php

/**
 * This file contains UserAccessSource class.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Service\UUID;
use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\Source\UserAccessSourceInterface;
use ThoPHPAuthorization\Source\UserSourceInterface;
use ThoPHPAuthorization\Data\User\UserRequestInterface;
use ThoPHPAuthorization\Data\User\UserForgotPasswordRequest;

/**
 * UserAccessSource is a class, that contains methods to work with user access requests.
 *
 * This class contains basic functionality to work with user access requests.
 * Security key in this case contains 2 parts:
 * - Encoded with base64, user identified
 * - Encoded with base64, user request type
 * - Encoded with UUID v5, user security key with specified name
 */
class UserAccessSource implements UserAccessSourceInterface
{
    /**
     * User source service.
     *
     * @var UserSourceInterface
     */
    protected $userSource;

    /**
     * Name to use in UUID v5.
     *
     * When generating UUID v5, user request type could be added as part of name.
     *
     * @var string
     */
    protected $name = 'user_access';

    /**
     * Constructor.
     *
     * @param UserSourceInterface $user_source User source.
     * @param string|null $name Name to use in UUID v5.
     *
     * @return void
     */
    public function __construct(UserSourceInterface $user_source, $name = null)
    {
        $this->userSource = $user_source;
        if (!is_null($name)) {
            $this->name = $name;
        }
    }

    /**
     * Decode encoded data
     *
     * @param string $string Encoded data.
     *
     * @return string|null Decoded data or null.
     */
    public function decode($string)
    {
        $result = base64_decode($string, true);
        return $result ?: null;
    }

    /**
     * Encode data
     *
     * @param string $string Encoded data.
     *
     * @return string
     */
    public function encode($string)
    {
        return base64_encode($string);
    }

    /**
     * Create security key
     *
     * @param UserInterface $user User object.
     * @param string $type Request type.
     *
     * @return string
     */
    public function createSecurity(UserInterface $user, $type)
    {
        $user_security = $user->getSecurity();
        $namespace = UUID::isValid($user_security) ? $user_security : UUID::fromHash(sha1($user_security));
        return $this->encode($this->encode($user->getIdentity()) . '-' . $this->encode($type)
            . '-' . UUID::v5($namespace, $this->name . $type));
    }

    /**
     * {@inheritdoc}
     */
    public function getBySecurity($security)
    {
        $parts = explode('-', $this->decode($security));
        $user_identity = $this->decode($parts[0]);
        $type = $this->decode($parts[1]);
        if (!$user_identity || !$type) {
            return null;
        }
        $user = $this->userSource->getByIdentity($user_identity);
        if ($user && $this->createSecurity($user, $type) === $security) {
            return $this->create($user, [
                'type' => $type
            ]);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, $data = null)
    {
        $create_data = is_array($data) ? $data : [];
        $create_data['user'] = $user;
        $type = isset($data['type']) ? $data['type'] : null;
        $create_data['security'] = $this->createSecurity($user, $type);
        switch ($type) {
            case UserForgotPasswordRequest::TYPE:
                return new UserForgotPasswordRequest($create_data);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(UserRequestInterface $request, $data = null)
    {
        $user = $request->getUser();
        switch ($request::TYPE) {
            case UserForgotPasswordRequest::TYPE:
                return isset($data['password'])
                    ? $this->userSource->edit(
                        $user,
                        [
                            'password' => $data['password']
                        ]
                    )
                    : false;
        }
        return false;
    }
}
