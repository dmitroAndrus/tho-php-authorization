<?php

/**
 * This file contains AbstractSMTPStream class.
 * php version 7.4
 *
 * Simplified version of SMTP from https://github.com/PHPMailer.
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Stream;

use ThoPHPAuthorization\Log\DebugLogInterface;
use ThoPHPAuthorization\Stream\StreamInterface;
use ThoPHPAuthorization\Stream\StreamStatus;
use ThoPHPAuthorization\Exception\ExitException;

/**
 * AbstractSMTPStream is a class, that contains methods to work with files.
 */
abstract class AbstractSMTPStream extends AbstractStream implements SMTPStreamInterface
{
    /**
     * SMTP emprty From email address message.
     *
     * @var string.
     */
    public static $smtpEmptyFromMsg = 'SMTP ({stream_name}) empty From email address.';

    /**
     * SMTP error Receiver email address message.
     *
     * @var string.
     */
    public static $smtpEmptyReceiverMsg = 'SMTP ({stream_name}) empty Receiver email address.';

    /**
     * SMTP error message.
     *
     * @var string.
     */
    public static $smtpErrorMsg = 'Error! SMTP ({stream_name}) error: {details}: {code}';

    /**
     * SMTP time limit reached message.
     *
     * @var string.
     */
    public static $smtpTimelimitMsg = 'SMTP {command} timelimit reached "{timelimit}" sec. Stream: {stream_name}';

    /**
     * SMTP stream command contains line breaks error.
     *
     * @var string.
     */
    public static $smtpCommandLineBreaksErrorMsg = 'Error! Command "{command}" contained line breaks. ' .
        'Stream: {stream_name}';

    /**
     * SMTP response message.
     *
     * @var string.
     */
    public static $smtpResponseMsg = 'SMTP ({stream_name}) command "{command}" response "{response}"';

    /**
     * SMTP command failed message.
     *
     * @var string.
     */
    public static $smtpCommandFailedMsg = 'Error! SMTP ({stream_name}) command "{command}" failed. ' .
        'Code {code} - {details}';

    /**
     * SMTP authentification failed message.
     *
     * @var string.
     */
    public static $smtpAuthentificationErrorMsg = 'SMTP ({stream_name}) authentification failed.';

    /**
     * SMTP inbound message.
     *
     * @var string.
     */
    public static $smtpInboundMsg = 'SMTP ({stream_name}) inbound: {$text}';

    /**
     * The maximum line length allowed for replies in RFC 5321 section 4.5.3.1.5,
     * *including* a trailing CRLF line break.
     *
     * @see https://tools.ietf.org/html/rfc5321#section-4.5.3.1.5
     *
     * @var integer
     */
    public const MAX_REPLY_LENGTH = 512;

    /**
     * The maximum lenght of message sent.
     * According to rfc 821 we should not send more than 1000 including the CRLF.
     *
     * @var integer
     */
    public const MAX_MESSAGE_LENGTH = 998;

    /**
     * SMTP line break constant.
     *
     * @var string
     */
    public const LINE_BREAK = "\r\n";

    /**
     * How long to wait for commands to complete, in seconds.
     * Default of 5 minutes (300sec) is from RFC2821 section 4.5.3.2.
     *
     * @var integer
     */
    public static $timelimit = 300;

    /**
     * SMTP Host name.
     *
     * @var string
     */
    protected $hostname;

    /**
     * SMTP Host is TLS.
     *
     * @var boolean
     */
    protected $tls;

    /**
     * SMTP User name.
     *
     * @var string
     */
    protected $username;

    /**
     * SMTP User password.
     *
     * @var string
     */
    protected $password;

    /**
     * SMTP Port.
     *
     * @var string
     */
    protected $port = 25;

    /**
     * SMTP Timeout.
     *
     * @var string
     */
    protected $timeout = 5;

    /**
     * Whether to use VERP.
     *
     * @see https://en.wikipedia.org/wiki/Variable_envelope_return_path
     * @see https://www.postfix.org/VERP_README.html Info on VERP
     *
     * @var boolean
     */
    protected $verp = false;

    /**
     * Constructor
     *
     * @param array|null $config - SMTP configurations.
     * @param DebugLogInterface|null $log - Log.
     */
    public function __construct($config = null, DebugLogInterface $log = null)
    {
        parent::__construct($log);
        // Set stream settings.
        if (is_array($config)) {
            if (isset($config['hostname']) && is_string($config['hostname'])) {
                $this->tls = substr($config['hostname'], 0, 3) === 'tls';
                $this->hostname = $this->tls ? substr($config['hostname'], 6) : $config['hostname'];
            }
            if (isset($config['username'])) {
                $this->username = $config['username'];
            }
            if (isset($config['password'])) {
                $this->password = $config['password'];
            }
            if (isset($config['port'])) {
                $this->port = (int) $config['port'];
            }
            if (isset($config['timeout'])) {
                $this->timeout = (int) $config['timeout'];
            }
            if (isset($config['verp'])) {
                $this->verp = !!$config['verp'];
            }
        }
    }

    /**
     * Do some thing after opening stream.
     *
     * @throws ExitException - If some command or authentification fails.
     *
     * @return self.
     */
    protected function afterOpen()
    {
        // SMTP server can take longer to respond, give longer timeout for first read.
        // Windows does not have support for this timeout function.
        if (strpos(PHP_OS, 'WIN') !== 0) {
            $max = (int) ini_get('max_execution_time');
            // Don't bother if unlimited, or if set_time_limit is disabled.
            if (
                0 !== $max
                && $this->timeout > $max
                && strpos(ini_get('disable_functions'), 'set_time_limit') === false
            ) {
                @set_time_limit($this->timeout);
            }
            stream_set_timeout($this->stream, $this->timeout, 0);
        }
        // Cleanup creation response if any.
        $this->getResponse();
        // Send hello to SMTP server.
        $this->sendCommand('EHLO', 'EHLO' . ' ' . getenv('SERVER_ADDR'), 250);
        $this->startTLS();
        if (!$this->authenticate()) {
            $this->error(static::$smtpAuthentificationErrorMsg, null, StreamStatus::SENDING_ERROR);
        }
        return $this;
    }

    /**
     * Terminate current stream.
     *
     * @param boolean $force - Try to forcefuly termination stream.
     *
     * @throws ExitException - If not forced and QUIT command fails.
     *
     * @return boolean - Stream termination result.
     */
    protected function terminateStream($force = false)
    {
        try {
            $this->sendCommand('QUIT', 'QUIT', 221);
        } catch (ExitException $e) {
            // If forced - ignore ExitException, else - pass it further.
            if (!$force) {
                throw $e;
            }
        }
        return @fclose($this->stream);
    }

    /**
     * Read data to from the server.
     *
     * @param string $data - The data to send.
     * @param string $command - The comand this is part of, only for tracking.
     *
     * @return integer|boolean The number of bytes sent to the server or false on error.
     */
    protected function readData()
    {
        return @fgets($this->stream, static::MAX_REPLY_LENGTH);
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
     * Get stream response.
     *
     * Time limit options:
     * 0 - to no limit.
     * null - to take time limit from the static::$timelimit.
     *
     * @param integer|null $timelimit - Time limit.
     *
     * @return string|null
     */
    protected function getResponse($timelimit = null)
    {
        if (!$this->canRead()) {
            return null;
        }
        if (is_null($timelimit)) {
            $timelimit = static::$timelimit;
        }
        // Enter busy state.
        $this->setStatus(StreamStatus::BUSY);
        $str = '';
        $endtime = 0;
        stream_set_timeout($this->stream, $this->timeout);
        if ($timelimit > 0) {
            $endtime = time() + $timelimit;
        }
        while (is_resource($this->stream) && !feof($this->stream)) {
            // Deliberate noise suppression - errors are handled afterwards
            $reply = $this->readData();
            $this->debug(static::$smtpInboundMsg, ['text' => $str]);
            $str .= $reply;
            /*
                If response is only 3 chars (not valid, but RFC5321 S4.2 says it must be handled),
                or 4th character is a space or a line break char, we are done reading, break the loop.
                String array access is a significant micro-optimisation over strlen.
            */
            if (!isset($reply[3]) || $reply[3] === ' ' || $reply[3] === "\r" || $reply[3] === "\n") {
                break;
            }
            // Timed-out? Break.
            $info = stream_get_meta_data($this->stream);
            if ($info['timed_out']) {
                $this->debug(static::$smtpTimedoutMsg, [
                    'command' => 'getResponse',
                    'timeout' => $this->timeout
                ]);
                break;
            }
            // Check if reading took too long.
            if ($endtime && time() > $endtime) {
                $this->debug(static::$smtpTimelimitMsg, [
                    'command' => 'getResponse',
                    'timelimit' => $timelimit
                ]);
                break;
            }
        }
        // Return to open state.
        $this->setStatus(StreamStatus::OPEN);

        return $str;
    }

    /**
     * Send data to the server.
     *
     * @param string $data - The data to send.
     * @param string $command - The comand this is part of, only for tracking.
     *
     * @return integer|boolean The number of bytes sent to the server or false on error.
     */
    protected function sendData($data, $command = '')
    {
        return @fwrite($this->stream, $data);
    }

    /**
     * Send a command to an SMTP server and check its return code.
     *
     * @param string $command - The command name, not send to server, only to track.
     * @param string $command_string - The actual command to send.
     * @param integer|integer[] $expect - One or more expected integer success codes.
     * @param integer $timelimit - Time limit to receive response from SMTP server.
     *
     * @throws ExitException - If command fails.
     *
     * @return boolean - Command execution fail or success.
     */
    protected function sendCommand($command, $command_string, $expect, $timelimit = null)
    {
        if (!$this->canSend()) {
            return false;
        }
        // Reject line breaks in all commands.
        if (
            !(
                strpos($command_string, "\n") === false
                && strpos($command_string, "\r") === false
            )
        ) {
            $this->error(static::$smtpCommandLineBreaksErrorMsg, [
                'command' => $command
            ], StreamStatus::SENDING_ERROR);
        }
        // Enter busy state.
        $this->setStatus(StreamStatus::BUSY);
        $this->sendData($command_string . static::LINE_BREAK, $command);
        // Return to open state.
        $this->setStatus(StreamStatus::OPEN);
        // Get SMTP server response.
        $response = $this->getResponse($timelimit);
        $matches = [];
        if (preg_match('/^([\d]{3})[ -](?:([\d]\\.[\d]\\.[\d]{1,2}) )?/', $response, $matches)) {
            $code = (int) $matches[1];
            $code_ex = (count($matches) > 2 ? $matches[2] : null);
            // Cut off error code from each response line.
            $detail = preg_replace(
                "/{$code}[ -]" .
                ($code_ex ? str_replace('.', '\\.', $code_ex) . ' ' : '') . '/m',
                '',
                $response
            );
        } else {
            // Fall back to simple parsing, if regex fails.
            $code = (int) substr($response, 0, 3);
            $code_ex = null;
            $detail = substr($response, 4);
        }
        $this->debug(static::$smtpResponseMsg, [
            'command' => $command,
            'response' => $response
        ]);
        if (in_array($code, (array) $expect, true)) {
            // Everything seems to be ok.
            return true;
        }
        // Handle error.
        $this->error(static::$smtpCommandFailedMsg, [
            'command' => $command,
            'code' => $code,
            'code_ex' => $code_ex,
            'detail' => $detail,
        ], StreamStatus::SENDING_ERROR);
    }

    /**
     * Start TLS.
     *
     * @throws ExitException - If STARTTLS command fails.
     *
     * @return boolean - TLS started.
     */
    protected function startTLS()
    {
        if (!$this->tls) {
            return false;
        }
        $this->sendCommand('STARTTLS', 'STARTTLS', 220);
        stream_socket_enable_crypto($this->stream, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        return true;
    }

    /**
     * Perform SMTP authentication.
     *
     * @throws ExitException - If some of SMTP server commands fails.
     *
     * @return boolean - Authentication success or failure.
     */
    protected function authenticate()
    {
        // Check if can send data to SMTP server.
        if (!$this->canSend()) {
            return false;
        }
        // Try to go throught SMTP server authentication.
        if (empty($this->username) || empty($this->password)) {
            $this->sendCommand('HELO', 'HELO' . ' ' . getenv('SERVER_NAME'), 250);
        } else {
            $this->sendCommand('EHLO', 'EHLO' . ' ' . getenv('SERVER_ADDR'), 250);
            $this->sendCommand('AUTH', 'AUTH LOGIN', 334);
            $this->sendCommand('USERNAME', base64_encode($this->username), 334);
            $this->sendCommand('PASSWORD', base64_encode($this->password), 235);
        }
        return true;
    }

    /**
     * Send a data line to the SMTP server.
     *
     * Part of the sendMail method.
     * Sends lines backwards.
     *
     * @param string $line - Data line to send.
     * @param string $prepend - Data to prepend to new line.
     *
     * @return void.
     */
    protected function sendDataLine($line, $prepend = '')
    {
        $lines_out = [];
        $max_message_length = static::MAX_MESSAGE_LENGTH;
        while (isset($line[$max_message_length])) {
            // Try to find a space within the last $max_message_length chars of the line to break on,
            // to avoid breaking in the middle of a word.
            $pos = strrpos(substr($line, 0, $max_message_length), ' ');
            $pos = $pos ? $pos + 1 : $max_message_length - 1;
            $lines_out[] = substr($line, 0, $pos);
            $line = $prepend . substr($line, $pos);
        }
        $lines_out[] = $line;

        // Send the lines to the server.
        foreach ($lines_out as $line_out) {
            // Dot-stuffing as per RFC5321 section 4.5.2
            // https://tools.ietf.org/html/rfc5321#section-4.5.2
            if (!empty($line_out) && $line_out[0] === '.') {
                $line_out = '.' . $line_out;
            }
            // Enter busy state.
            $this->setStatus(StreamStatus::BUSY);
            $this->sendData($line_out . static::LINE_BREAK, 'DATA');
            // Return to open state.
            $this->setStatus(StreamStatus::OPEN);
        }
    }

    /**
     * Send mail headers to the SMTP server.
     *
     * Part of the sendMail method.
     *
     * @param string|string[] $headers - Mail headers.
     *
     * @return void.
     */
    protected function sendHeadersData($headers)
    {
        $result = [];
        $lines = [];
        if (is_array($headers)) {
            foreach ($headers as $name => $value) {
                $lines[] = $name . ': ' . $value;
            }
        } else {
            $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $headers));
        }
        foreach ($lines as $line) {
            // If processing headers add a LWSP-char to the front of new line RFC822 section 3.1.1.
            $this->sendDataLine($line, "\t");
        }
    }

    /**
     * Send mail message to the SMTP server.
     *
     * Part of the sendMail method.
     *
     * @param string $message - Mail message.
     *
     * @return void.
     */
    protected function sendMessageData($message)
    {
        $result = [];
        $lines = [];
        if (is_array($message)) {
            foreach ($message as $name => $value) {
                $lines[] = $name . ': ' . $value;
            }
        } else {
            $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $message));
        }
        $max_message_length = static::MAX_MESSAGE_LENGTH;
        foreach ($lines as $line) {
            $this->sendDataLine($line);
        }
    }

    /**
     * Send mail.
     *
     * @param string $from_email - From email address.
     * @param string|string[] $receiver_email - Single or all receivers email addresses, including CC and BCC receivers.
     * @param string $message - Mail message.
     * @param string|string[]|null $headers - Additional mail headers.
     *
     * @return string - File content.
     */
    public function sendMail($from_email, $receiver_email, $message, $headers = null)
    {
        if (!$this->canSendMail()) {
            return false;
        }
        if (empty($from_email)) {
            $this->debug(static::$smtpEmptyFromMsg);
        }
        if (empty($receiver_email)) {
            $this->debug(static::$smtpEmptyReceiverMsg);
        }
        try {
            $use_verp = ($this->verp ? ' XVERP' : '');
            // Send from emails to SMTP server.
            $this->sendCommand('MAIL FROM', 'MAIL FROM: <' . $from_email . '>' . $use_verp, 250);
            // Send all receivers emails to SMTP server.
            if (is_array($receiver_email)) {
                foreach ($receiver_email as $email) {
                    $this->sendCommand('RCPT TO', 'RCPT TO: <' . $email . '>', [250, 251]);
                }
            } else {
                $this->sendCommand('RCPT TO', 'RCPT TO: <' . $receiver_email . '>', [250, 251]);
            }
            // Start sending mail data.
            $this->sendCommand('DATA', 'DATA', 354);
            // If there are headers - send it first.
            if (!is_null($headers)) {
                $header_lines = $this->sendHeadersData($headers);
            }
            $header_lines = $this->sendMessageData($message);
            // Mail data has been sent.
            // End the DATA command with increased time limit.
            return $this->sendCommand('DATA END', '.', 250, 2 * static::$timelimit);
        } catch (ExitException $e) {
            // Failed to send email.
        }
        return false;
    }

    /**
     * Check if can send commands stream.
     *
     * @return boolean.
     */
    public function canSend()
    {
        return $this->isOpen();
    }

    /**
     * Check if can send mail.
     *
     * @return boolean.
     */
    public function canSendMail()
    {
        return $this->getStatus() === StreamStatus::OPEN;
    }
}
