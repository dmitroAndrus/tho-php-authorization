<?php

/**
 * This file contains File class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\File;

use ThoPHPAuthorization\Data\File\FileInterface;
use ThoPHPAuthorization\Data\File\SRCTrait;
use ThoPHPAuthorization\Stream\FileStream;

/**
 * File is a class to manipulate file data.
 */
class File implements FileInterface
{
    use SRCTrait;

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return FileStream::readFile($this->getSRC());
    }

    /**
     * {@inheritdoc}
     */
    public function exists()
    {
        // Be aware! allow_url_fopen should be activated for checking external files URL like:
        // http://www.mydomain.com/images/my-image.jpg
        return file_exists($this->getSRC());
    }
}
