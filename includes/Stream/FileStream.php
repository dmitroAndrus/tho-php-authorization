<?php

/**
 * This file contains FileStream class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Stream;

use ThoPHPAuthorization\Log\DebugLogInterface;
use ThoPHPAuthorization\Stream\AbstractStream;
use ThoPHPAuthorization\Exception\ExitException;
use ThoPHPAuthorization\Stream\StreamStatus;
use ThoPHPAuthorization\Service\TemplatingService;

/**
 * FileStream is a class, that contains methods to work with files.
 */
class FileStream extends AbstractStream
{
    /**
     * File reading started message.
     *
     * @var string.
     */
    public static $fileReadingStartedMsg = 'Started reading file. File: {stream_name}';

    /**
     * File reading finished message.
     *
     * @var string.
     */
    public static $fileReadingFinishedMsg = 'Finished reading file. File: {stream_name}';

    /**
     * File reading finished message.
     *
     * @var string.
     */
    public static $fileReadingErrorMsg = 'Failed to read file. File: {stream_name}';

    /**
     * Read file.
     *
     * @param string $src - File src.
     * @param DebugLogInterface $log - Log.
     *
     * @var mixed - File content.
     */
    public static function readFile(string $src, DebugLogInterface $log = null)
    {
        $stream = new FileStream($src, 'r', $log);
        $content = null;
        if ($stream->open()) {
            $content = $stream->getContent();
            // Forcefully close file.
            $stream->close(true);
        }
        return $content;
    }

    /**
     * File part length per step (one request) on reading.
     *
     * @var integer
     */
    public static $readLen = 8192;

    /**
     * File src.
     *
     * @var string
     */
    protected $src;

    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * Stream metadata.
     *
     * @var array
     */
    protected $metadata;

    /**
     * Constructor
     *
     * @param string $src - File src.
     * @param mixed $mode - File stream mode.
     * @param DebugLogInterface $log - Log.
     *
     * @var void
     */
    public function __construct(string $src, $mode = 'r', DebugLogInterface $log = null)
    {
        parent::__construct($log);
        $this->src = $src;
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->src;
    }

    /**
     * {@inheritdoc}
     */
    protected function createStream()
    {
        // Silent open file.
        return @fopen($this->src, $this->mode);
    }

    /**
     * {@inheritdoc}
     */
    protected function terminateStream($force = false)
    {
        // Silent close file.
        if (@fclose($this->stream)) {
            $this->metadata = null;
            return true;
        }
        return false;
    }

    /**
     * Read from the stream.
     *
     * @return string - Stream content.
     */
    protected function readStreamPart()
    {
        // Silently read file part.
        return @fread($this->stream, static::$readLen);
    }

    /**
     * Rewind the position of the file pointer.
     *
     * @return boolean - Returns true on success or false on failure.
     */
    public function rewind()
    {
        if ($this->isOpen()) {
            if (!$this->metadata) {
                $this->metadata = @stream_get_meta_data($this->stream);
            }
            return $this->metadata && $this->metadata['seekable'] && @rewind($this->stream);
        }
        return false;
    }

    /**
     * Check if can read stream.
     *
     * @return self.
     */
    public function canRead()
    {
        return $this->getStatus() === StreamStatus::OPEN;
    }

    /**
     * Get file content part.
     *
     * @throws ExitException - When failed to read file.
     *
     * @return string|null - File content.
     */
    protected function readPart()
    {
        // Check if stream is open and reached file end.
        if ($this->canRead() && !feof($this->stream)) {
            // Enter busy state.
            $this->setStatus(StreamStatus::BUSY);
            // Read file part from the stream.
            $part = $this->readStreamPart();
            if (false === $part) {
                $this->error(static::$fileReadingErrorMsg, StreamStatus::READING_ERROR);
            }
            // Return to open state.
            $this->setStatus(StreamStatus::OPEN);
            return $part;
        }
        return null;
    }

    /**
     * Normalize content.
     *
     * @param string|mixed $content - Content to normalize.
     *
     * @return string|null- Normalized cotent or null.
     */
    public function normalizeContent($content)
    {
        return empty($content)
            ? null
            : $content;
    }

    /**
     * Get the file content.
     *
     * Will try to open stream, read all file content and close stream after.
     *
     * @return string - File content.
     */
    public function getContent()
    {
        $content = '';
        try {
            // Check if can read.
            if ($this->canRead()) {
                // Try to rewind file position to get all file content.
                $this->rewind();
                $this->debug(static::$fileReadingStartedMsg);
                while ($part = $this->readPart()) {
                    $content .= $part;
                }
                $this->debug(static::$fileReadingFinishedMsg);
            }
        } catch (ExitException $e) {
            // Most likely getting file content failed.
        }
        return $this->normalizeContent($content);
    }
}
