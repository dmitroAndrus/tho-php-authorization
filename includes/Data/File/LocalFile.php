<?php

/**
 * This file contains LocalFile class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\File;

use ThoPHPAuthorization\Data\File\File;
use ThoPHPAuthorization\Data\File\PathTrait;
use ThoPHPAuthorization\Data\File\LocalFileInterface;
use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\Stream\FileStream;

/**
 * LocalFile is a class to manipulate local file data.
 */
class LocalFile extends File implements LocalFileInterface
{
    use PathTrait;

    /**
     * Constructor.
     *
     * @param string $source File path.
     *
     * @return void
     */
    public function __construct($source)
    {
        $this->setPath($source);
    }

    /**
     * Set path to the file.
     *
     * @param string $path Path.
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->src = null;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSRC()
    {
        if (!$this->src && $this->path) {
            $this->src = HTTPService::pathToSRC($path);
        }
        return $this->src;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseName()
    {
        return $this->path
            ? basename($this->path)
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->exists()
            ? FileStream::readFile($this->getPath())
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function exists()
    {
        return file_exists($this->getPath());
    }
}
