<?php
# This file is part of InvisCMS .
#
#    InvisCMS is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    Foobar is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with InvisCMS.  If not, see <http://www.gnu.org/licenses/>.
?><?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Mail
 * @subpackage Transport
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
/**
 * Abstract for sending eMails through different
 * ways of transport
 *
 * @category   Zend
 * @package    Zend_Mail
 * @subpackage Transport
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class smtpAbstract {
    /**
     * Mail body
     * @var string 
     * @access public
     */
    public $body = '';
    /**
     * MIME boundary
     * @var string 
     * @access public
     */
    public $boundary = '';
    /**
     * Mail header string
     * @var string 
     * @access public
     */
    public $header = '';
    /**
     * Array of message headers
     * @var array 
     * @access protected
     */
    protected $_headers = array();
    /**
     * Message is a multipart message
     * @var boolean 
     * @access protected
     */
    protected $_isMultipart = false;
    /**
     * Zend_Mail object
     * @var false|Zend_Mail 
     * @access protected
     */
    protected $_mail = false;
    /**
     * Array of message parts
     * @var array 
     * @access protected
     */
    protected $_parts = array();
    /**
     * Recipients string
     * @var string 
     * @access public
     */
    public $recipients = '';
    /**
     * EOL character string used by transport
     * @var string 
     * @access public
     */
    public $EOL = "\r\n";
    /**
     * Send an email independent from the used transport
     *
     * The requisite information for the email will be found in the following
     * properties:
     *
     * - {@link $recipients} - list of recipients (string)
     * - {@link $header} - message header
     * - {@link $body} - message body
     */
    abstract protected function _sendMail();
    /**
     * Return all mail headers as an array
     *
     * If a boundary is given, a multipart header is generated with a
     * Content-Type of either multipart/alternative or multipart/mixed depending
     * on the mail parts present in the {@link $_mail Zend_Mail object} present.
     *
     * @param string $boundary
     * @return array
     */
    protected function _getHeaders($boundary)
    {
        if (null !== $boundary) {
            // Build multipart mail
            if ($this->_mail->hasAttachments) {
                $type = Zend_Mime::MULTIPART_MIXED;
            } elseif ($this->_mail->getBodyText() && $this->_mail->getBodyHtml()) {
                $type = Zend_Mime::MULTIPART_ALTERNATIVE;
            } else {
                $type = Zend_Mime::MULTIPART_MIXED;
            }
            $this->_headers['Content-Type'] = array(
                $type . '; charset="' . $this->_mail->getCharset() . '";'
                . $this->EOL
                . " " . 'boundary="' . $boundary . '"'
            );
            $this->_headers['MIME-Version'] = array('1.0');
            $this->boundary = $boundary;
        }
        return $this->_headers;
    }
    /**
     * Prepend header name to header value
     * 
     * @param string $item 
     * @param string $key 
     * @param string $prefix 
     * @static
     * @access protected
     * @return void
     */
    protected static function _formatHeader(&$item, $key, $prefix)
    {
        $item = $prefix . ': ' . $item;
    }
    /**
     * Prepare header string for use in transport
     *
     * Prepares and generates {@link $header} based on the headers provided.
     * 
     * @param mixed $headers 
     * @access protected
     * @return void
     * @throws Zend_Mail_Transport_Exception if any header lines exceed 998
     * characters
     */
    protected function _prepareHeaders($headers)
    {
        if (!$this->_mail) {
            throw new Zend_Mail_Transport_Exception('Missing Zend_Mail object in _mail property');
        }
        foreach ($headers as $header => $content) {
            if (isset($content['append'])) {
                unset($content['append']);
                $value = implode(',' . $this->EOL . ' ', $content);
                $this->header .= $header . ': ' . $value . $this->EOL;
            } else {
                array_walk($content, array(get_class($this), '_formatHeader'), $header);
                $this->header .= implode($this->EOL, $content) . $this->EOL;
            }
        }
        // Sanity check on headers -- should not be > 998 characters
        $sane = true;
        foreach (explode($this->EOL, $this->header) as $line) {
            if (strlen(trim($line)) > 998) {
                $sane = false;
                break;
            }
        }
        if (!$sane) {
            throw new Zend_Mail_Exception('At least one mail header line is too long');
        }
    }
    /**
     * Generate MIME compliant message from the current configuration
     *
     * If both a text and HTML body are present, generates a
     * multipart/alternative Zend_Mime_Part containing the headers and contents
     * of each. Otherwise, uses whichever of the text or HTML parts present. 
     *
     * The content part is then prepended to the list of Zend_Mime_Parts for
     * this message.
     *
     * @return void
     */
    protected function _buildBody()
    {
        if (($text = $this->_mail->getBodyText()) 
            && ($html = $this->_mail->getBodyHtml())) 
        {
            // Generate unique boundary for multipart/alternative
            $mime = new Zend_Mime(null);
            $boundaryLine = $mime->boundaryLine($this->EOL);
            $boundaryEnd  = $mime->mimeEnd($this->EOL);
            $text->disposition = false;
            $html->disposition = false;
            $body = $boundaryLine
                  . $text->getHeaders($this->EOL)
                  . $this->EOL
                  . $text->getContent()
                  . $this->EOL
                  . $boundaryLine
                  . $html->getHeaders($this->EOL)
                  . $this->EOL
                  . $html->getContent()
                  . $this->EOL
                  . $boundaryEnd;
            $mp           = new Zend_Mime_Part($body);
            $mp->type     = Zend_Mime::MULTIPART_ALTERNATIVE;
            $mp->boundary = $mime->boundary();
            $this->_isMultipart = true;
            
            // Ensure first part contains text alternatives
            array_unshift($this->_parts, $mp);
            // Get headers
            $this->_headers = $this->_mail->getHeaders();
            return;
        } 
        
        // If not multipart, then get the body
        if (false !== ($body = $this->_mail->getBodyHtml())) {
            array_unshift($this->_parts, $body);
        } elseif (false !== ($body = $this->_mail->getBodyText())) {
            array_unshift($this->_parts, $body);
        }
        if (!$body) {
            throw new Zend_Mail_Transport_Exception('No body specified');
        }
        // Get headers
        $this->_headers = $this->_mail->getHeaders();
        $headers = $body->getHeadersArray($this->EOL);
        foreach ($headers as $header) {
            // Headers in Zend_Mime_Part are kept as arrays with two elements, a
            // key and a value
            $this->_headers[$header[0]] = array($header[1]);
        }
    }
    /**
     * Send a mail using this transport
     * 
     * @param Zend_Mail $mail 
     * @access public
     * @return void
     * @throws Zend_Mail_Transport_Exception if mail is empty
     */
    public function send(mail $mail)
    {
        $this->_isMultipart = false;
        $this->_mail        = $mail;
        $this->_parts       = $mail->getParts();
        $mime               = $mail->getMime();
#die_r($this);
        // Build body content
        $this->_buildBody();
        // Determine number of parts and boundary
        $count    = count($this->_parts);
        $boundary = null;
        if ($count < 1) {
            throw new Zend_Mail_Transport_Exception('Empty mail cannot be sent');
        }
        if ($count > 1) {
            // Multipart message; create new MIME object and boundary
            $mime     = new Zend_Mime($this->_mail->getMimeBoundary());
            $boundary = $mime->boundary();
        } elseif ($this->_isMultipart) {
            // multipart/alternative -- grab boundary
            $boundary = $this->_parts[0]->boundary;
        }
        // Determine recipients, and prepare headers
        $this->recipients = implode(',', $mail->getRecipients());
        $this->_prepareHeaders($this->_getHeaders($boundary));
        // Create message body
        // This is done so that the same Zend_Mail object can be used in
        // multiple transports
        $message = new Zend_Mime_Message();
        $message->setParts($this->_parts);
        $message->setMime($mime);
        $this->body = $message->generateMessage($this->EOL);
        // Send to transport!
        $this->_sendMail();
    }
}
