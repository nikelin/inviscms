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
 * @package    Zend_Mime
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @category   Zend
 * @package    Zend_Mime
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Mime_Message {
    protected $_parts = array();
    protected $_mime = null;
    /**
     * Returns the list of all Zend_Mime_Parts in the message
     *
     * @return array of Zend_Mime_Part
     */
    public function getParts()
    {
        return $this->_parts;
    }
    /**
     * Sets the given array of Zend_Mime_Parts as the array for the message
     *
     * @param array $parts
     */
    public function setParts($parts)
    {
        $this->_parts = $parts;
    }
    /**
     * Append a new Zend_Mime_Part to the current message
     *
     * @param Zend_Mime_Part $part
     */
    public function addPart(Zend_Mime_Part $part)
    {
        /**
         * @todo check for duplicate object handle
         */
        $this->_parts[] = $part;
    }
    /**
     * Check if message needs to be sent as multipart
     * MIME message or if it has only one part.
     *
     * @return boolean
     */
    public function isMultiPart()
    {
        return (count($this->_parts) > 1);
    }
    /**
     * Set Zend_Mime object for the message 
     *
     * This can be used to set the boundary specifically or to use a subclass of
     * Zend_Mime for generating the boundary.
     *
     * @param Zend_Mime $mime
     */
    public function setMime(Zend_Mime $mime)
    {
        $this->_mime = $mime;
    }
    /**
     * Returns the Zend_Mime object in use by the message
     *
     * If the object was not present, it is created and returned. Can be used to
     * determine the boundary used in this message.
     *
     * @return Zend_Mime
     */
    public function getMime()
    {
        if ($this->_mime === null) {
            $this->_mime = new Zend_Mime();
        }
        return $this->_mime;
    }
    /**
     * Generate MIME-compliant message from the current configuration
     *
     * This can be a multipart message if more than one MIME part was added. If
     * only one part is present, the content of this part is returned. If no
     * part had been added, an empty string is returned.
     *
     * Parts are seperated by the mime boundary as defined in Zend_Mime. If
     * {@link setMime()} has been called before this method, the Zend_Mime
     * object set by this call will be used. Otherwise, a new Zend_Mime object
     * is generated and used.
     *
     * @param string $EOL EOL string; defaults to {@link Zend_Mime::LINEEND}
     * @return string
     */
    public function generateMessage($EOL = Zend_Mime::LINEEND)
    {
        if (! $this->isMultiPart()) {
            $body = array_shift($this->_parts);
            $body = $body->getContent();
        } else {
            $mime = $this->getMime();
            $boundaryLine = $mime->boundaryLine($EOL);
            $body = 'This is a message in Mime Format.  If you see this, '
                  . "your mail reader does not support this format." . $EOL;
            foreach (array_keys($this->_parts) as $p) {
                $body .= $boundaryLine 
                       . $this->getPartHeaders($p, $EOL)
                       . $EOL
                       . $this->getPartContent($p);
            }
            $body .= $mime->mimeEnd($EOL);
        }
        return trim($body);
    }
    /**
     * Get the headers of a given part as an array
     *
     * @param int $partnum
     * @return array
     */
    public function getPartHeadersArray($partnum)
    {
        return $this->_parts[$partnum]->getHeadersArray();
    }
    /**
     * Get the headers of a given part as a string
     *
     * @param int $partnum
     * @return string
     */
    public function getPartHeaders($partnum, $EOL = Zend_Mime::LINEEND)
    {
        return $this->_parts[$partnum]->getHeaders($EOL);
    }
    /**
     * Get the (encoded) content of a given part as a string
     *
     * @param int $partnum
     * @return string
     */
    public function getPartContent($partnum)
    {
        return $this->_parts[$partnum]->getContent();
    }
    /**
     * Explode MIME multipart string into seperate parts
     *
     * Parts consist of the header and the body of each MIME part.
     *
     * @param string $body
     * @param string $boundary
     * @return array
     */
    static protected function _disassembleMime($body, $boundary)
    {
        $start = 0;
        $res = array();
        // find every mime part limiter and cut out the
        // string before it.
        // the part before the first boundary string is discarded:
        $p = strpos($body, '--'.$boundary."\n", $start);
        if ($p === false) {
            // no parts found!
            return array();  
        }
        
        // position after first boundary line
        $start = $p + 3 + strlen($boundary); 
        while (($p = strpos($body, '--' . $boundary . "\n", $start)) !== false) {
            $res[] = substr($body, $start, $p-$start);
            $start = $p + 3 + strlen($boundary);
        }
        
        // no more parts, find end boundary
        $p = strpos($body, '--' . $boundary . '--', $start);
        if ($p===false) {
            throw new Zend_Exception('Not a valid Mime Message: End Missing');
        }
        
        // the remaining part also needs to be parsed:
        $res[] = substr($body, $start, $p-$start);
        return $res;
    }
    /**
     * Decodes a MIME encoded string and returns a Zend_Mime_Message object with
     * all the MIME parts set according to the given string
     *
     * @param string $message
     * @param string $boundary
     * @param string $EOL EOL string; defaults to {@link Zend_Mime::LINEEND}
     * @return Zend_Mime_Message
     */
    public static function createFromMessage($message, $boundary, $EOL = Zend_Mime::LINEEND)
    {
        $partsStr = self::_disassembleMime($message, $boundary);
        if (count($partsStr)<=0) return null;
        $res = new Zend_Mime_Message();
        foreach($partsStr as $part) {
            // separate header and body
            $header = true;  // expecting header lines first
            $headersfound = array();
            $body = '';
            $lastheader = '';
            $lines = explode("\n", $part);
            
            // read line by line
            foreach ($lines as $line) {
                $line = trim($line);
                if ($header) {
                    if ($line == '') {
                        $header=false;
                    } elseif (strpos($line, ':')) {
                        list($key, $value) = explode(':', $line, 2);
                        $headersfound[trim($key)] = trim($value);
                        $lastheader = trim($key);
                    } else {
                        if ($lastheader!='') {
                            $headersfound[$lastheader] .= ' '.trim($line);
                        } else {
                            // headers do not start with an ordinary header line?
                            // then assume no headers at all
                            $header = false; 
                        }
                    }
                } else {
                    $body .= $line . $EOL;
                }
            }
            // now we build a new MimePart for the current Message Part:
            $newPart = new Zend_Mime_Part($body);
            foreach ($headersfound as $key => $value) {
                /**
                 * @todo check for characterset and filename
                 */
                switch($key) {
                    case 'Content-Type':
                        $newPart->type = $value;
                        break;
                    case 'Content-Transfer-Encoding':
                        $newPart->encoding = $value;
                        break;
                    case 'Content-ID':
                        $newPart->id = trim($value,'<>');
                        break;
                    case 'Content-Disposition':
                        $newPart->disposition = $value;
                        break;
                    case 'Content-Description':
                        $newPart->description = $value;
                        break;
                    default:
                        throw new Zend_Exception('Unknown header ignored for MimePart:'.$key);
                }
            }
            $res->addPart($newPart);
        }
        return $res;
    }
}
