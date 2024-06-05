<?php

/**
 * This file contains FsockSMTPStream class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Stream;

use ThoPHPAuthorization\Stream\AbstractSMTPStream;
use ThoPHPAuthorization\Data\Name\StrictNameTrait;
use ThoPHPAuthorization\Log\DebugLog;

/**
 * FsockSMTPStream is a class, that contains methods to work with SMTP stream created with fsockopen.
 */
class FsockSMTPStream extends AbstractSMTPStream
{
    use StrictNameTrait;

    public static function create($config = null, DebugLogInterface $log = null)
    {
        return new FsockSMTPStream($config, is_null($log) ? DebugLog::$defaultLog : $log);
    }

    /**
     * {@inheritdoc}
     */
    public function __construct($config = null, DebugLogInterface $log = null)
    {
        parent::__construct($config, $log);
        $this->name = is_array($config) && isset($config['name']) && $config['name']
            ? $config['name']
            : 'FsockSMTPStream';
    }

    /**
     * {@inheritdoc}
     */
    protected function createStream()
    {
        $stream = @fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);
        if (!is_resource($stream)) {
            // Stream opening failed.
            $this->error(static::$smtpErrorMsg, [
                'details' => $errstr,
                'code' => $errno
            ]);
        }
        return $stream;
    }
}
