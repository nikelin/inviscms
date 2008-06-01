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
class sape_client extends sape_base {
	var $_links_delimiter = '';
	var $_links = array();
	var $_links_page = array();
	var $_user_agent = 'SAPE_Client PHP';

    function sape_client($options = null) {
    	parent::init($options);
        $this->load_data();
    }
    /*
     * Cc���� ����� ���������� �� ������
     */
    function return_links($n = null, $offset = 0) {
        if (is_array($this->_links_page)) {
            $total_page_links = count($this->_links_page);
            if (!is_numeric($n) || $n > $total_page_links) {
                $n = $total_page_links;
            }
            $links = array();
            for ($i = 1; $i <= $n; $i++) {
                if ($offset > 0 && $i <= $offset) {
                    array_shift($this->_links_page);
                } else {
                    $links[] = array_shift($this->_links_page);
                }
            }
            $html = join($this->_links_delimiter, $links);
            
            if ($this->_is_our_bot) {
                $html = '<sape_noindex>' . $html . '</sape_noindex>';
            }
            
            return $html;
        } else {
            return $this->_links_page;
        }
    }
    function _get_db_file() {
        if ($this->_multi_site) {
            return $this->_path .'/'. $this->_host . '.links.db';
        } else {
            return $this->_path.'/links.db';
        }
    }
    function _get_dispenser_path(){
    	return '/code.php?user=' . $this->_user_code . '&host=' . $this->_host;
    }
    function set_data($data){
    	$this->_links = $data;
        if (isset($this->_links['__sape_delimiter__'])) {
            $this->_links_delimiter = $this->_links['__sape_delimiter__'];
        }
        if (array_key_exists($this->_request_uri, $this->_links) && is_array($this->_links[$this->_request_uri])) {
            $this->_links_page = $this->_links[$this->_request_uri];
        } else {
        	if (isset($this->_links['__sape_new_url__']) && strlen($this->_links['__sape_new_url__'])) {
        		if ($this->_is_our_bot || $this->_force_show_code){
        			$this->_links_page = $this->_links['__sape_new_url__'];
        		}
        	}
        }
    }
}
?>