<?php

/**
 * This file contains Mail class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Mail;

use ThoPHPAuthorization\Mail\AbstractMail;
use ThoPHPAuthorization\Data\Email\HasReceiverInterface;
use ThoPHPAuthorization\Data\Email\ReceiverTrait;
use ThoPHPAuthorization\Data\Email\HasReplyToInterface;
use ThoPHPAuthorization\Data\Email\ReplyToTrait;
use ThoPHPAuthorization\Data\Email\HasSenderInterface;
use ThoPHPAuthorization\Data\Email\SenderTrait;
use ThoPHPAuthorization\Data\Email\HasCCReceiversInterface;
use ThoPHPAuthorization\Data\Email\CCReceiversTrait;
use ThoPHPAuthorization\Data\Email\HasBCCReceiversInterface;
use ThoPHPAuthorization\Data\Email\BCCReceiversTrait;
use ThoPHPAuthorization\Data\File\HasAttachmentsInterface;
use ThoPHPAuthorization\Data\File\AttachmentsTrait;

/**
 * Mail is a class, that contains mail data.
 */
class Mail extends AbstractMail implements
    HasReceiverInterface,
    HasReplyToInterface,
    HasSenderInterface,
    HasCCReceiversInterface,
    HasBCCReceiversInterface,
    HasAttachmentsInterface
{
    use ReceiverTrait;
    use ReplyToTrait;
    use SenderTrait;
    use CCReceiversTrait;
    use BCCReceiversTrait;
    use AttachmentsTrait;

    /**
     * Constructor.
     *
     * @param array|null $data - Mail data, array with mail subject, text, etc..
     *
     * @return void
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
        if (is_array($data)) {
            $email = null;
            $name = null;
            if (static::emailAndNameFromData($data, 'receiver', $email, $name)) {
                $this->setReceiver($email, $name);
            }
            if (static::emailAndNameFromData($data, 'reply_to', $email, $name)) {
                $this->setReplyTo($email, $name);
            }
            if (static::emailAndNameFromData($data, 'sender', $email, $name)) {
                $this->setSender($email, $name);
            }
            if (isset($data['cc_receivers'])) {
                foreach ($data['cc_receivers'] as $item) {
                    if (static::emailAndNameFrom($item, $email, $name)) {
                        $this->addCCReceiver($email, $name);
                    }
                }
            }
            if (isset($data['bcc_receivers'])) {
                foreach ($data['bcc_receivers'] as $item) {
                    if (static::emailAndNameFrom($item, $email, $name)) {
                        $this->addBCCReceiver($email, $name);
                    }
                }
            }
            if (isset($data['attachment'])) {
                $this->addAttachment($data['attachment']);
            }
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $item) {
                    $this->addAttachment($item);
                }
            }
        }
    }
}
