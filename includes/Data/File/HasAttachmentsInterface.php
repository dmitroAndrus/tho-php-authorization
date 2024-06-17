<?php

/**
 * This file contains HasAttachmentsInterface interface.
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

/**
 * HasAttachmentsInterface is an interface, it declares a possibility to manipulate attachment files.
 */
interface HasAttachmentsInterface
{
    /**
     * Add attachment.
     *
     * @param mixed $file File attachment.
     *
     * @return self
     */
    public function addAttachment($file);

    /**
     * Get all attachments.
     *
     * @return LocalFileInterface[]|null List of all attachments or null when none found.
     */
    public function getAttachments();

    /**
     * Check if has atleast some attachments.
     *
     * @return boolean
     */
    public function hasAttachments();
}
