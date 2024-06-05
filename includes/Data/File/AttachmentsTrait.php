<?php

/**
 * This file contains AttachmentsTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\File;

use ThoPHPAuthorization\Data\File\LocalFileInterface;
use ThoPHPAuthorization\Data\File\LocalFile;

/**
 * AttachmentsTrait is a trait, it contains basic methods to manipulate attachment files.
 *
 * Implements everything from ThoPHPAuthorization\Data\Email\HasAttachmentsInterface.
 */
trait AttachmentsTrait
{
    /**
     * Attachments.
     *
     * @var LocalFileInterface[]
     */
    protected $atachments = [];

    /**
     * Add attachment.
     *
     * @param mixed $file - File attachment.
     *
     * @return self
     */
    public function addAttachment($file)
    {
        if ($file instanceof LocalFileInterface) {
            $this->atachments[] = $file;
        } elseif (is_string($file)) {
            $this->atachments[] = new LocalFile($file);
        }
        return $this;
    }

    /**
     * Get all atachments.
     *
     * @return EmailInterface[]|null - All available atachments or null when none found.
     */
    public function getAttachments()
    {
        return $this->hasAttachments() ? $this->atachments : null;
    }

    /**
     * Check if has atleast some attachments.
     *
     * @return boolean.
     */
    public function hasAttachments()
    {
        return !empty($this->atachments);
    }
}
