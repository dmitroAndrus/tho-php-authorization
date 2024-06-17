<?php

/**
 * This file contains AbstractMail class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Mail;

use ThoPHPAuthorization\Mail\MailInterface;
use ThoPHPAuthorization\Data\Email\FromTrait;

/**
 * AbstractMail is an abstract class, that contains basic mail data.
 */
abstract class AbstractMail implements MailInterface
{
    use FromTrait;

    /**
     * Email subject.
     *
     * @var string
     */
    protected $subject;

    /**
     * Email text.
     *
     * @var string
     */
    protected $text;

    /**
     * Email html.
     *
     * @var string
     */
    protected $html;

    /**
     * Get email and name from value.
     *
     * @param array $data Email data.
     * @param string|null $email Email address, will be set in this variable.
     * @param string|null $name Email name, will be set in this variable.
     *
     * @return boolean Success when email or name was found, or false otherwise.
     */
    public static function emailAndNameFrom($value, &$email = null, &$name = null)
    {
        $email = null;
        $name = null;
        if (is_array($value)) {
            $email = isset($value['email']) ? $value['email'] : null;
            $name = isset($value['name']) ? $value['name'] : null;
        } elseif (is_string($value)) {
            $email = $value;
        }
        return !(is_null($email) && is_null($name));
    }

    /**
     * Get email and name from data array.
     *
     * @param array $data Array data.
     * @param string $prop Preperty name.
     * @param string|null $email Email address, will be set in this variable.
     * @param string|null $name Email name, will be set in this variable.
     *
     * @return boolean Success when email or name was found, or false otherwise.
     */
    public static function emailAndNameFromData($data, $prop = null, &$email = null, &$name = null)
    {
        if (is_null($prop)) {
            return static::emailAndNameFrom($data, $email, $name);
        }
        $email = null;
        if (isset($data[$prop])) {
            if (is_array($data[$prop])) {
                return static::emailAndNameFrom($data[$prop], $email, $name);
            }
            $email = $data[$prop];
        }
        $name = null;
        if (isset($data[$prop . '_name'])) {
            $name = $data[$prop . '_name'];
        }
        return !(is_null($email) && is_null($name));
    }

    /**
     * Constructor.
     *
     * @param array|null $data Mail data, array with mail subject, text, etc..
     *
     * @return void
     */
    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['subject'])) {
                $this->setSubject($data['subject']);
            }
            if (isset($data['text'])) {
                $this->setText($data['text']);
            }
            if (isset($data['html'])) {
                $this->setHTML($data['html']);
            }
            $email = null;
            $name = null;
            if (static::emailAndNameFromData($data, 'from', $email, $name)) {
                $this->setFrom($email, $name);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function setHTML($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHTML()
    {
        return $this->html;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHTML()
    {
        return !empty($this->html);
    }
}
