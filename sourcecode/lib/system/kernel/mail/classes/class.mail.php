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
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
/**
 * Class for sending an email.
 *
 * @category   Zend
 * @package    Zend_Mail
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class mail extends Zend_Mime_Message
{
    /**#@+
     * @access protected
     */
    /**
     * @var Zend_Mail_Transport_Abstract
     * @static
     */
    static protected $_defaultTransport = null;
    /**
     * Mail character set
     * @var string
     */
    protected $_charset = null;
    /**
     * Mail headers
     * @var array
     */
    protected $_headers = array();
    /**
     * From: address
     * @var string
     */
    protected $_from = null;
    /**
     * To: addresses
     * @var array
     */
    protected $_to = array();
    /**
     * Array of all recipients
     * @var array
     */
    protected $_recipients = array();
    /**
     * Return-Path header
     * @var string 
     */
    protected $_returnPath = null;
    /**
     * Subject: header
     * @var string
     */
    protected $_subject = null;
    /**
     * text/plain MIME part
     * @var false|Zend_Mime_Part
     */
    protected $_bodyText = false;
    /**
     * text/html MIME part
     * @var false|Zend_Mime_Part
     */
    protected $_bodyHtml = false;
    /**
     * MIME boundary string
     * @var string
     */
    protected $_mimeBoundary = null;
    /**#@-*/
    /**
     * Flag: whether or not email has attachments
     * @var boolean
     * @access public
     */
    public $hasAttachments = false;
    /**
     * Sets the default mail transport for all following uses of
     * Zend_Mail::send();
     *
     * @todo Allow passing a string to indicate the transport to load
     * @todo Allow passing in optional options for the transport to load
     * @param  Zend_Mail_Transport_Abstract $transport
     */
    static public function setDefaultTransport(Zend_Mail_Transport_Abstract $transport)
    {
        self::$_defaultTransport = $transport;
    }
    /**
     * Public constructor
     *
     * @param string $charset
     */
    public function __construct($charset='utf-8')
    {
        $this->_charset = $charset;
    }
    /**
     * Return charset string
     * 
     * @access public
     * @return string
     */
    public function getCharset()
    {
        return $this->_charset;
    }
    /**
     * Set an arbitrary mime boundary for the message
     *
     * If not set, Zend_Mime will generate one.
     *
     * @param string $boundary
     */
    public function setMimeBoundary($boundary)
    {
      $this->_mimeBoundary = $boundary;
    }
    /**
     * Return the boundary string used for the message
     *
     * @return string
     */
    public function getMimeBoundary()
    {
        return $this->_mimeBoundary;
    }
    /**
     * Sets the text body for the message.
     *
     * @param string $txt
     * @param string $charset
     * @return Zend_Mime_Part
    */
    public function setBodyText($txt, $charset=null)
    {
        if ($charset === null) {
            $charset = $this->_charset;
        }
        $mp = new Zend_Mime_Part($txt);
        $mp->encoding = Zend_Mime::ENCODING_QUOTEDPRINTABLE;
        $mp->type = Zend_Mime::TYPE_TEXT;
        $mp->disposition = Zend_Mime::DISPOSITION_INLINE;
        $mp->charset = $charset;
        $this->_bodyText = $mp;
        return $mp;
    }
    /**
     * Return text body Zend_Mime_Part
     * 
     * @access public
     * @return false|Zend_Mime_Part
     */
    public function getBodyText()
    {
        return $this->_bodyText;
    }
    /**
     * Sets the HTML body for the message
     *
     * @param string $html
     * @param string $charset
     * @return Zend_Mime_Part
     */
    public function setBodyHtml($html, $charset=null)
    {
        if ($charset === null) {
            $charset = $this->_charset;
        }
        $mp = new Zend_Mime_Part($html);
        $mp->encoding = Zend_Mime::ENCODING_QUOTEDPRINTABLE;
        $mp->type = Zend_Mime::TYPE_HTML;
        $mp->disposition = Zend_Mime::DISPOSITION_INLINE;
        $mp->charset = $charset;
        $this->_bodyHtml = $mp;
        return $mp;
    }
    /**
     * Return Zend_Mime_Part representing body HTML
     * 
     * @access public
     * @return false|Zend_Mime_Part
     */
    public function getBodyHtml()
    {
        return $this->_bodyHtml;
    }
    /**
     * Adds an attachment to the message
     *
     * @param string $body
     * @param string $mimeType
     * @param string $disposition
     * @param string $encoding
     * @return Zend_Mime_Part Newly created Zend_Mime_Part object (to allow
     * advanced settings)
     */
    public function addAttachment($body,
                                  $mimeType    = Zend_Mime::TYPE_OCTETSTREAM,
                                  $disposition = Zend_Mime::DISPOSITION_ATTACHMENT,
                                  $encoding    = Zend_Mime::ENCODING_BASE64)
    {
        $mp = new Zend_Mime_Part($body);
        $mp->encoding = $encoding;
        $mp->type = $mimeType;
        $mp->disposition = $disposition;
        $this->addPart($mp);
        $this->hasAttachments = true;
        return $mp;
    }
    /**
     * Return a count of message parts
     * 
     * @access public
     * @return void
     */
    public function getPartCount()
    {
        return count($this->_parts);
    }
    /**
     * Encode header fields 
     *
     * Encodes header content according to RFC1522 if it contains non-printable
     * characters.
     *
     * @param string $value
     * @return string
     */
    protected function _encodeHeader($value)
    {
      if (Zend_Mime::isPrintable($value)) {
          return $value;
      } else {
          $quotedValue = Zend_Mime::encodeQuotedPrintable($value);
          $quotedValue = str_replace('?', '=3F', $quotedValue);
          return '=?' . $this->_charset . '?Q?' . $quotedValue . '?=';
      }
    }
    /**
     * Add a header to the message
     *
     * Adds a header to this message. If append is true and the header already
     * exists, raises a flag indicating that the header should be appended.
     *
     * @param string $headerName
     * @param string $value
     * @param boolean $append
     */
    protected function _storeHeader($headerName, $value, $append=false)
    {
        $value = strtr($value,"\r\n\t",'???');
        if (isset($this->_headers[$headerName])) {
            $this->_headers[$headerName][] = $value;
        } else {
            $this->_headers[$headerName] = array($value);
        }
        if ($append) {
            $this->_headers[$headerName]['append'] = true;
        }
    }
    /**
     * Add a recipient
     *
     * @param string $email
     */
    protected function _addRecipient($email, $to = false)
    {
        // prevent duplicates
        $this->_recipients[$email] = 1;
        if ($to) {
            $this->_to[] = $email;
        }
    }
    /**
     * Helper function for adding a recipient and the corresponding header
     *
     * @param string $headerName
     * @param string $name
     * @param string $email
     */
    protected function _addRecipientAndHeader($headerName, $name, $email)
    {
        $email = strtr($email,"\r\n\t",'???');
        $this->_addRecipient($email, ('To' == $headerName) ? true : false);
        if ($name != '') {
            $name = $this->_encodeHeader('"' .$name. '" ');
        }
        $this->_storeHeader($headerName, $name .'<'. $email . '>', true);
    }
    /**
     * Adds To-header and recipient
     *
     * @param string $name
     * @param string $email
     */
    public function addTo($email, $name='')
    {
        $this->_addRecipientAndHeader('To', $name, $email);
    }
    /**
     * Adds Cc-header and recipient
     *
     * @param string $name
     * @param string $email
     */
    public function addCc($email, $name='')
    {
        $this->_addRecipientAndHeader('Cc', $name, $email);
    }
    /**
     * Adds Bcc recipient
     *
     * @param string $email
     */
    public function addBcc($email)
    {
        $this->_addRecipientAndHeader('Bcc', '', $email);
    }
    /**
     * Return list of recipient email addresses
     *
     * @return array (of strings)
     */
    public function getRecipients()
    {
        return array_keys($this->_recipients);
    }
    /**
     * Sets From-header and sender of the message
     *
     * @param string $email
     * @param string $name
     * @throws Zend_Mail_Exception if called subsequent times
     */
    public function setFrom($email, $name = '')
    {
        if ($this->_from === null) {
            $email = strtr($email,"\r\n\t",'???');
            $this->_from = $email;
            $this->_storeHeader('From', $this->_encodeHeader('"'.$name.'"').' <'.$email.'>', true);
        } else {
            throw new Zend_Mail_Exception('From Header set twice');
        }
    }
    /**
     * Returns the sender of the mail
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->_from;
    }
    /**
     * Sets the Return-Path header for an email
     * 
     * @access public
     * @param string $email 
     * @return void
     * @throws Zend_Mail_Exception if set multiple times
     */
    public function setReturnPath($email)
    {
        if ($this->_returnPath === null) {
            $email = strtr($email,"\r\n\t",'???');
            $this->_returnPath = $email;
            $this->_storeHeader('Return-Path', $email, false);
        } else {
            throw new Zend_Mail_Exception('Return-Path Header set twice');
        }
    }
    /**
     * Returns the current Return-Path address for the email
     *
     * If no Return-Path header is set, returns the value of {@link $_from}.
     * 
     * @access public
     * @return string
     */
    public function getReturnPath()
    {
        if (null !== $this->_returnPath) {
            return $this->_returnPath;
        }
        return $this->_from;
    }
    /**
     * Sets the subject of the message
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        if ($this->_subject === null) {
            $subject = strtr($subject,"\r\n\t",'???');
            $this->_subject = $this->_encodeHeader($subject);
            $this->_storeHeader('Subject', $this->_subject);
        } else {
            throw new Zend_Mail_Exception('Subject set twice');
        }
    }
    /**
     * Returns the encoded subject of the message
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
    }
    /**
     * Add a custom header to the message
     *
     * @param string $name
     * @param string $value
     * @param boolean $append
     * @throws Zend_Mail_Exception on attempts to create standard headers
     */
    public function addHeader($name, $value, $append=false)
    {
        if (in_array(strtolower($name), array('to', 'cc', 'bcc', 'from', 'subject', 'return-path'))) {
            throw new Zend_Mail_Exception('Cannot set standard header from addHeader()');
        }
        $value = strtr($value,"\r\n\t",'???');
        $value = $this->_encodeHeader($value);
        $this->_storeHeader($name, $value, $append);
    }
    /**
     * Return mail headers
     * 
     * @access public
     * @return void
     */
    public function getHeaders()
    {
        return $this->_headers;
    }
    /**
     * Sends this email using the given transport or a previously
     * set DefaultTransport or the internal mail function if no
     * default transport had been set.
     *
     * @param Zend_Mail_Transport_Abstract $transport
     * @return void
     */
    public function send($transport=null)
    {
     	$transport = new sendmail();
        $transport->send($this);
    }
}
?>