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
?><?PHP
class sape_base {
    var $_version           = '1.0.3';
	var $_user_code			= 'a882a74543edaa1898b198975899c569';
	
	var $_path='';
    var $_verbose           = false;
    var $_charset           = 'utf-8';               // http://www.php.net/manual/en/function.iconv.php
    var $_server_list       = array('dispenser-01.sape.ru', 'dispenser-02.sape.ru');
    var $_cache_lifetime    = 3600;             // ��������� ��� ������ :�)
    // ���� ������� ���� ������ �� �������, �� ��������� ������� ����� ����� ������� ������
    var $_cache_reloadtime  = 600;
    var $_error             = '';
    var $_host              = '';
    var $_request_uri       = '';
    var $_multi_site        = false;
    var $_fetch_remote_type = '';              // ������ ����������� � ��������� ������� [file_get_contents|curl|socket]
    var $_socket_timeout    = 6;               // ������� ����� ������
    var $_force_show_code   = false;
    var $_is_our_bot 		= false;           //���� ��� �����
    var $_debug             = false;
	var $_db_file     		= '';				//���� � ����� � �������
    function sape_base($options = null) {
    }
	
	function init($option=null)
	{
		$this->_path=$GLOBALS['path_to_site']. '/'. $this->_user_code;
        // ������� :o)
        $host = '';
        if (is_array($options)) {
            if (isset($options['host'])) {
                $host = $options['host'];
            }
        } elseif (strlen($options)) {
            $host = $options;
            $options = array();
        } else {
            $options = array();
        }
        // ����� ����?
        if (strlen($host)) {
            $this->_host = $host;
        } else {
            $this->_host = $_SERVER['HTTP_HOST'];
        }
        $this->_host = preg_replace('/^http:\/\//', '', $this->_host);
        $this->_host = preg_replace('/^www\./', '', $this->_host);
        // ����� ��������?
        if (isset($options['request_uri']) && strlen($options['request_uri'])) {
            $this->_request_uri = $options['request_uri'];
        } else {
            $this->_request_uri = $_SERVER['REQUEST_URI'];
        }
        // �� ������, ���� ������� ����� ������ � ����� �����
        if (isset($options['multi_site']) && $options['multi_site'] == true) {
            $this->_multi_site = true;
        }
        // �������� �� �������
        if (isset($options['verbose']) && $options['verbose'] == true) {
            $this->_verbose = true;
        }
        // ���������
        if (isset($options['charset']) && strlen($options['charset'])) {
            $this->_charset = $options['charset'];
        }
        if (isset($options['fetch_remote_type']) && strlen($options['fetch_remote_type'])) {
            $this->_fetch_remote_type = $options['fetch_remote_type'];
        }
        if (isset($options['socket_timeout']) && is_numeric($options['socket_timeout']) && $options['socket_timeout'] > 0) {
            $this->_socket_timeout = $options['socket_timeout'];
        }
        // ������ �������� ���-���
        if (isset($options['force_show_code']) && $options['force_show_code'] == true) {
            $this->_force_show_code = true;
        }
        // �������� ���������� � ������
        if (isset($options['debug']) && $options['debug'] == true) {
            $this->_debug = true;
        }
        // ���������� ��� �� �����
        if (isset($_COOKIE['sape_cookie']) && ($_COOKIE['sape_cookie'] == $this->_user_code)) {
            $this->_is_our_bot = true;
            if (isset($_COOKIE['sape_debug']) && ($_COOKIE['sape_debug'] == 1)){
                $this->_debug = true;
            }
        } else {
            $this->_is_our_bot = false;
        }
        //������������ ������
        srand((float)microtime() * 1000000);
      //  shuffle($this->_server_list);
	 }

    /*
     * ������� ��� ����������� � ��������� �������
     */
    function fetch_remote_file($host, $path) {
        $user_agent = $this->_user_agent.' '.$this->_version;
        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $this->_socket_timeout);
        @ini_set('user_agent',               $user_agent);
        if (
            $this->_fetch_remote_type == 'file_get_contents'
            ||
            (
                $this->_fetch_remote_type == ''
                &&
                function_exists('file_get_contents')
                &&
                ini_get('allow_url_fopen') == 1
            )
        ) {
			$this->_fetch_remote_type = 'file_get_contents';
            if ($data = @file_get_contents('http://' . $host . $path)) {
                return $data;
            }
        } elseif (
            $this->_fetch_remote_type == 'curl'
            ||
            (
                $this->_fetch_remote_type == ''
                &&
                function_exists('curl_init')
            )
        ) {
			$this->_fetch_remote_type = 'curl';
            if ($ch = @curl_init()) {
                @curl_setopt($ch, CURLOPT_URL,              'http://' . $host . $path);
                @curl_setopt($ch, CURLOPT_HEADER,           false);
                @curl_setopt($ch, CURLOPT_RETURNTRANSFER,   true);
                @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,   $this->_socket_timeout);
                @curl_setopt($ch, CURLOPT_USERAGENT,        $user_agent);
                if ($data = @curl_exec($ch)) {
                    return $data;
                }
                @curl_close($ch);
            }
        } else {
			$this->_fetch_remote_type = 'socket';
            $buff = '';
            $fp = @fsockopen($host, 80, $errno, $errstr, $this->_socket_timeout);
            if ($fp) {
                @fputs($fp, "GET {$path} HTTP/1.0\r\nHost: {$host}\r\n");
                @fputs($fp, "User-Agent: {$user_agent}\r\n\r\n");
                while (!@feof($fp)) {
                    $buff .= @fgets($fp, 128);
                }
                @fclose($fp);
                $page = explode("\r\n\r\n", $buff);
                return $page[1];
            }
        }
        return $this->raise_error('�� ���� ������������ � �������: ' . $host . $path.', type: '.$this->_fetch_remote_type);
    }
    /*
     * ������� ������ �� ���������� �����
     */
    function _read($filename) {
        $fp = @fopen($filename, 'rb');
        @flock($fp, LOCK_SH);
        if ($fp) {
            clearstatcache();
            $length = @filesize($filename);
            $mqr = get_magic_quotes_runtime();
            set_magic_quotes_runtime(0);
            if ($length) {
                $data = @fread($fp, $length);
            } else {
                $data = '';
            }
            set_magic_quotes_runtime($mqr);
            @flock($fp, LOCK_UN);
            @fclose($fp);
            return $data;
        }
        return $this->raise_error('�� ���� ������� ������ �� �����: ' . $filename);
    }
    /*
     * ������� ������ � ��������� ����
     */
    function _write($filename, $data) {
        $fp = @fopen($filename, 'wb');
        if ($fp) {
            @flock($fp, LOCK_EX);
            $length = strlen($data);
            @fwrite($fp, $data, $length);
            @flock($fp, LOCK_UN);
            @fclose($fp);
            if (md5($this->_read($filename)) != md5($data)) {
                return $this->raise_error('�������� ����������� ������ ��� ������ � ����: ' . $filename);
            }
            return true;
        }
        return $this->raise_error('�� ���� �������� ������ � ����: ' . $filename);
    }
    /*
     * ������� ��������� ������
     */
    function raise_error($e) {
        $this->_error = '<p style="color: red; font-weight: bold;">SAPE ERROR: ' . $e . '</p>';
        if ($this->_verbose == true) {
            print $this->_error;
        }
        return false;
    }
    protected function load_data() {
        $this->_db_file = $this->_get_db_file();
        if (!is_file($this->_db_file)) {
            // �������� ������� ����.
            if (@touch($this->_db_file)) {
                @chmod($this->_db_file, 0666);    // ����� �������
            } else {
                return $this->raise_error('��� ����� ' . $this->_db_file . '. ������� �� �������. ��������� ����� 777 �� �����.');
            }
        }
        if (!is_writable($this->_db_file)) {
            return $this->raise_error('��� ������� �� ������ � �����: ' . $this->_db_file . '! ��������� ����� 777 �� �����.');
        }
        @clearstatcache();
        if (filemtime($this->_db_file) < (time()-$this->_cache_lifetime) || filesize($this->_db_file) == 0) {
            // ����� �� �������� �������� ������� � ����� �� ���� ������������� ��������
            @touch($this->_db_file, (time() - $this->_cache_lifetime + $this->_cache_reloadtime));
            $path = $this->_get_dispenser_path();
            if (strlen($this->_charset)) {
                $path .= '&charset=' . $this->_charset;
            }
            foreach ($this->_server_list as $i => $server){
	            if ($data = $this->fetch_remote_file($server, $path)) {
	                if (substr($data, 0, 12) == 'FATAL ERROR:') {
	                    $this->raise_error($data);
	                } else {
	                    // [������]�������� �����������:
	                    if (@unserialize($data) != false) {
	                        $this->_write($this->_db_file, $data);
	                        break;
	                    }
	                }
	            }
            }
        }
        // ������� PHPSESSID
        if (strlen(session_id())) {
            $session = session_name() . '=' . session_id();
            $this->_request_uri = str_replace(array('?'.$session,'&'.$session), '', $this->_request_uri);
        }
        if ($data = $this->_read($this->_db_file)) {
        	$this->set_data(@unserialize($data));
        }
    }
}