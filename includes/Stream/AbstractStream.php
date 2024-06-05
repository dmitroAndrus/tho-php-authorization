<?php

/**
 * This file contains AbstractStream class.
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
use ThoPHPAuthorization\Log\DebugLog;
use ThoPHPAuthorization\Log\ReadableDebugLogTrait;
use ThoPHPAuthorization\Stream\StreamStatus;
use ThoPHPAuthorization\Stream\StreamInterface;
use ThoPHPAuthorization\Exception\ExitException;
use ThoPHPAuthorization\Service\TemplatingService;

/**
 * AbstractStream is an abstract class, that contains basic methods to work with stream.
 */
abstract class AbstractStream implements StreamInterface
{
    // Provide public read only access to log.
    use ReadableDebugLogTrait;

    /**
     * Stream open message.
     *
     * @var string.
     */
    public static $streamOpenMsg = 'Opened stream: {stream_name}';

    /**
     * Stream open error message.
     *
     * @var string.
     */
    public static $streamOpenErrorMsg = 'Error! Failed to open stream: {stream_name}';

    /**
     * Stream close error message.
     *
     * @var string.
     */
    public static $streamCloseErrorMsg = 'Error! Failed to close stream: {stream_name}';

    /**
     * Stream close message.
     *
     * @var string.
     */
    public static $streamCloseMsg = 'Closed stream: {stream_name}';

    /**
     * Stream.
     *
     * @var mixed
     */
    protected $stream;

    /**
     * Stream status.
     *
     * @var integer
     */
    protected $status;

    /**
     * Constructor.
     *
     * @param DebugLogInterface $log - Log.
     *
     * @var void
     */
    public function __construct(DebugLogInterface $log = null)
    {
        $this->log = is_null($log)
            ? new DebugLog()
            : $log;
        $this->setStatus(StreamStatus::CLOSED);
    }

    /**
     * Destructor.
     *
     * @var void
     */
    public function __destruct()
    {
        // Always close stream.
        if ($this->stream) {
            $this->close(true);
        }
    }

    /**
     * Get stream name.
     *
     * @return string.
     */
    abstract public function getName();

    /**
     * Check if stream can be opened.
     *
     * @return self.
     */
    public function canOpen()
    {
        return $this->getStatus() === StreamStatus::CLOSED;
    }

    /**
     * {@inheritdoc}
     */
    public function open($force = false)
    {
        try {
            // Check if stream is closed, or when forced try to close current stream, if any.
            if ($this->canOpen() || ($force && $this->close($force))) {
                // Do things before opening stream.
                $this->beforeOpen();
                // Create stream.
                $stream = $this->createStream();
                if (false === $stream) {
                    // Failed to open stream.
                    $this->error(static::$streamOpenErrorMsg);
                }
                $this->stream = $stream;
                $this->setStatus(StreamStatus::OPEN);
                if (static::$streamOpenMsg) {
                    $this->debug(static::$streamOpenMsg);
                }
                // Do things after opening stream.
                $this->afterOpen();
            }
        } catch (ExitException $e) {
            // Do nothing. But, probably it means that it failed to open the stream.
        }
        $is_open = $this->isOpen();
        if (!$is_open && $this->stream) {
            $this->close();
        }
        return $is_open;
    }

    /**
     * Check if stream can be closed.
     *
     * @return self.
     */
    public function canClose()
    {
        return $this->stream && !in_array(
            $this->getStatus(),
            [StreamStatus::CLOSE_ERROR, StreamStatus::BUSY],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function close($force = false)
    {
        try {
            if ($this->canClose() || ($force && $this->stream)) {
                // Do thing after opening stream.
                $this->beforeClose();
                // Try to close stream.
                $result = $this->terminateStream($force);
                if (!$force && false === $result) {
                    // Failed to close the stream.
                    $this->error(static::$streamCloseErrorMsg, null, StreamStatus::CLOSE_ERROR);
                }
                $this->stream = null;
                $this->setStatus(StreamStatus::CLOSED);
                if (static::$streamCloseMsg) {
                    $this->debug(static::$streamCloseMsg);
                }
                // Do thing after opening stream.
                $this->afterClose();
            }
        } catch (ExitException $e) {
            // Do nothing. But, probably it means that it failed to close the stream.
        }
        return $this->isClosed();
    }

    /**
     * {@inheritdoc}
     */
    public function isOpen()
    {
        return $this->getStatus() === StreamStatus::OPEN;
    }

    /**
     * {@inheritdoc}
     */
    public function isClosed()
    {
        return $this->getStatus() === StreamStatus::CLOSED;
    }

    /**
     * Set stream status.
     *
     * @param integer $status - New stream status.
     *
     * @return self.
     */
    protected function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Log error message end throw ExitException.
     *
     * @param string $message - Error message.
     * @param array|null $data - Error data.
     * @param integer $status - Error status.
     *
     * @throws ExitException - Always throws ExitException.
     *
     * @return void.
     */
    protected function error($message, $data = null, $status = null)
    {
        $data = is_array($data) ? $data : [];
        $data['stream_name'] = $this->getName();
        $this->log->error(TemplatingService::parseSimpleTemplate($message, $data));
        $this->setStatus(is_null($status) ? StreamStatus::ERROR : $status);
        throw ExitException::create($message, $data);
    }

    /**
     * Log notice message.
     *
     * @param string $message - Error message.
     * @param array|null $data - Error data.
     * @param integer $status - Error status.
     *
     * @return self.
     */
    protected function notice($message, $data = null)
    {
        $data = is_array($data) ? $data : [];
        $data['stream_name'] = $this->getName();
        $this->log->notice(TemplatingService::parseSimpleTemplate($message, $data));
        return $this;
    }

    /**
     * Log debug message.
     *
     * @param string $message - Error message.
     * @param array|null $data - Error data.
     * @param integer $status - Error status.
     *
     * @return self.
     */
    protected function debug($message, $data = null)
    {
        $data = is_array($data) ? $data : [];
        $data['stream_name'] = $this->getName();
        $this->log->debug(TemplatingService::parseSimpleTemplate($message, $data));
        return $this;
    }

    /**
     * Do some thing before opening stream.
     *
     * @return self.
     */
    protected function beforeOpen()
    {
        return $this;
    }

    /**
     * Do some thing after opening stream.
     *
     * @return self.
     */
    protected function afterOpen()
    {
        return $this;
    }

    /**
     * Create stream.
     *
     * @return mixed - Created stream.
     */
    abstract protected function createStream();

    /**
     * Do some thing before closing stream.
     *
     * @return self.
     */
    protected function beforeClose()
    {
        return $this;
    }

    /**
     * Do some thing after closing stream.
     *
     * @return self.
     */
    protected function afterClose()
    {
        return $this;
    }


    /**
     * Terminate current stream.
     *
     * @param boolean $force - Try to forcefuly termination stream.
     *
     * @return boolean - Stream termination result.
     */
    abstract protected function terminateStream($force = false);
}
