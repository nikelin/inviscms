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
class sape_context extends sape_base {

	var $_words = array();
	var $_words_page = array();
	var $_user_agent = 'SAPE_Context PHP';
    var $_filter_tags = array( "a", "textarea", "select", "script", "style", "label", "noscript" , "noindex", "button" );

    function sape_context($options = null) {
		parent::init($options);
        $this->load_data();
    }

    function replace_in_text_segment($text){
        $debug = '';
        if ($this->_debug){
            $debug .= "<!-- argument for replace_in_text_segment: \r\n".base64_encode($text)."\r\n -->";
        }
        if (count($this->_words_page) > 0) {

            $source_sentence = array();
            if ($this->_debug) {
                $debug .= '<!-- sentences for replace: ';
            }            
            //������� ������ �������� ������� ��� ������
            foreach ($this->_words_page as $n => $sentence){
                //�������� ��� �������� �� �������
                $special_chars = array(
                    '&amp;' => '&',
                    '&quot;' => '"',                
                    '&#039;' => '\'',
                    '&lt;' => '<',
                    '&gt;' => '>' 
                );
                $sentence = strip_tags($sentence);
                foreach ($special_chars as $from => $to){
                    str_replace($from, $to, $sentence);
                }
                //����������� ��� ���� ������� � ��������
                $sentence = htmlspecialchars($sentence);
                //���������
                $sentence = preg_quote($sentence, '/');
                $replace_array = array();
            	if (preg_match_all('/(&[#a-zA-Z0-9]{2,6};)/isU', $sentence, $out)){
            		for ($i=0; $i<count($out[1]); $i++){
            			$unspec = $special_chars[$out[1][$i]];
            			$real = $out[1][$i];
            		    $replace_array[$unspec] = $real;
            		}
            	}                 
            	//�������� �������� �� ��� (��������|������)
            	foreach ($replace_array as $unspec => $real){
                    $sentence = str_replace($real, '(('.$real.')|('.$unspec.'))', $sentence);    
            	}
            	//�������� ������� �� �������� ��� �������� ��������
                $source_sentences[$n] = str_replace(' ','((\s)|(&nbsp;))+',$sentence);
                
                if ($this->_debug) {
                    $debug .= $source_sentences[$n]."\r\n\r\n";
                }
            }
            
            if ($this->_debug) {
                $debug .= '-->';
            }            

            //���� ��� ������ �����, �� �� ����� ��������� <
            $first_part = true;
            //������ ���������� ��� ������
            
            if (count($source_sentences) > 0){

                $content = '';
                $open_tags = array(); //�������� ��������� ����
                $close_tag = ''; //�������� �������� ������������ ����

                //��������� �� ������� ������ ����
                $part = strtok(' '.$text, '<');

                while ($part !== false){
                    //���������� �������� ����
                    if (preg_match('/(?si)^(\/?[a-z0-9]+)/', $part, $matches)){
                        //���������� �������� ����
                        $tag_name = strtolower($matches[1]);
                        //���������� ����������� �� ���
                        if (substr($tag_name,0,1) == '/'){
                            $close_tag = substr($tag_name, 1);
                            if ($this->_debug) {
                              $debug .= '<!-- close_tag: '.$close_tag.' -->';
                            }
                        } else {
                            $close_tag = '';
                            if ($this->_debug) {
                              $debug .= '<!-- open_tag: '.$tag_name.' -->';
                            }
                        }
                        $cnt_tags = count($open_tags);
                        //���� ����������� ��� ��������� � ����� � ����� �������� ����������� �����
                        if (($cnt_tags  > 0) && ($open_tags[$cnt_tags-1] == $close_tag)){
                            array_pop($open_tags);
                            if ($this->_debug) {
                                $debug .= '<!-- '.$tag_name.' - deleted from open_tags -->';
                            }
                            if ($cnt_tags-1 ==0){
                                if ($this->_debug) {
                                    $debug .= '<!-- start replacement -->';
                                }
                            }
                        }

                        //���� ��� �������� ������ �����, �� ������������
                        if (count($open_tags) == 0){
                            //���� �� ����������� ���, �� �������� ���������
                            if (!in_array($tag_name, $this->_filter_tags)){
                                $split_parts = explode('>', $part, 2);
                                //������������������
                                if (count($split_parts) == 2){
                                    //�������� ������� ���� ��� ������
                                    foreach ($source_sentences as $n => $sentence){
                                        if (preg_match('/'.$sentence.'/', $split_parts[1]) == 1){
                                            $split_parts[1] = preg_replace('/'.$sentence.'/', str_replace('$','\$', $this->_words_page[$n]), $split_parts[1], 1);
                                            if ($this->_debug) {
                                                $debug .= '<!-- '.$sentence.' --- '.$this->_words_page[$n].' replaced -->';
                                            }
                                            
                                            //���� ��������, �� ������� ������� �� ������ ������
                                            unset($source_sentences[$n]);
                                            unset($this->_words_page[$n]);                                            
                                        }
                                    }
                                    $part = $split_parts[0].'>'.$split_parts[1];
                                    unset($split_parts);
                                }
                            } else {
                                //���� � ��� ���������� ���, �� �������� ��� � ���� ��������
                                $open_tags[] = $tag_name;
                                if ($this->_debug) {
                                    $debug .= '<!-- '.$tag_name.' - added to open_tags, stop replacement -->';
                                }
                            }
                        }
                    } else {
                        //���� ��� �������� ����, �� �������, ��� ����� ���� �����
                        foreach ($source_sentences as $n => $sentence){
                             if (preg_match('/'.$sentence.'/', $part) == 1){
                                $part = preg_replace('/'.$sentence.'/',  str_replace('$','\$', $this->_words_page[$n]), $part, 1);

                                if ($this->_debug) {
                                    $debug .= '<!-- '.$sentence.' --- '.$this->_words_page[$n].' replaced -->';
                                }
                                
                                //���� ��������, �� ������� ������� �� ������ ������,
                                //����� ���� ����� ������ ������������� �����
                                unset($source_sentences[$n]);
                                unset($this->_words_page[$n]);                                
                            }
                        }
                    }

                    //���� � ��� ����� ���������, �� �������
                    if ($this->_debug) {
                        $content .= $debug;
                        $debug = '';
                    }
                    //���� ��� ������ �����, �� �� ������� <
                    if ($first_part ){
                        $content .= $part;
                        $first_part = false;
                    } else {
                        $content .= $debug.'<'.$part;
                    }
                    //�������� �������� �����
                    unset($part);
                    $part = strtok('<');
                }
                $text = ltrim($content);
                unset($content);
            }
    } else {
        if ($this->_debug){
            $debug .= '<!-- No word`s for page -->';
        }
    }

    if ($this->_debug){
        $debug .= '<!-- END: work of replace_in_text_segment() -->';
    }

    if ($this->_is_our_bot || $this->_force_show_code || $this->_debug){
        $text = '<sape_index>'.$text.'</sape_index>';
        if (isset($this->_words['__sape_new_url__']) && strlen($this->_words['__sape_new_url__'])){
                $text .= $this->_words['__sape_new_url__'];
        }
    }

    if ($this->_debug){
        if (count($this->_words_page) > 0){
            $text .= '<!-- Not replaced: '."\r\n";
           foreach ($this->_words_page as $n => $value){
               $text .= $value."\r\n\r\n";
           }
           $text .= '-->';
        }
        
        $text .= $debug;
    }
             return $text;
    }

    /*
     * ������ ����
     *
     */
    function replace_in_page(&$buffer) {

        if (count($this->_words_page) > 0) {
            //��������� ������ �� sape_index
                 //��������� ���� �� ���� sape_index
                 $split_content = preg_split('/(?smi)(<\/?sape_index>)/', $buffer, -1);
                 $cnt_parts = count($split_content);
                 if ($cnt_parts > 1){
                     //���� ���� ���� ���� ���� sape_index, �� �������� ������
                     if ($cnt_parts >= 3){
                         for ($i =1; $i < $cnt_parts; $i = $i + 2){
                             $split_content[$i] = $this->replace_in_text_segment($split_content[$i]);
                         }
                     }
                    $buffer = implode('', $split_content);
                     if ($this->_debug){
                         $buffer .= '<!-- Split by Sape_index cnt_parts='.$cnt_parts.'-->';
                     }
                 } else {
                     //���� �� ����� sape_index, �� ������� ������� �� BODY
                     $split_content = preg_split('/(?smi)(<\/?body[^>]*>)/', $buffer, -1, PREG_SPLIT_DELIM_CAPTURE);
                     //���� ����� ���������� ����� body
                     if (count($split_content) == 5){
                         $split_content[0] = $split_content[0].$split_content[1];
                         $split_content[1] = $this->replace_in_text_segment($split_content[2]);
                         $split_content[2] = $split_content[3].$split_content[4];
                         unset($split_content[3]);
                         unset($split_content[4]);
                         $buffer = $split_content[0].$split_content[1].$split_content[2];
                         if ($this->_debug){
                             $buffer .= '<!-- Split by BODY -->';
                         }
                     } else {
                        //���� �� ����� sape_index � �� ������ ������� �� body
                         if ($this->_debug){
                             $buffer .= '<!-- Can`t split by BODY -->';
                         }
                     }
                 }

        } else {
            if (!$this->_is_our_bot && !$this->_force_show_code && !$this->_debug){
                $buffer = preg_replace('/(?smi)(<\/?sape_index>)/','', $buffer);
            } else {
                if (isset($this->_words['__sape_new_url__']) && strlen($this->_words['__sape_new_url__'])){
                        $buffer .= $this->_words['__sape_new_url__'];
                }
            }
            if ($this->_debug){
               $buffer .= '<!-- No word`s for page -->';
            }
        }
        return $buffer;
    }

    function _get_db_file() {
        if ($this->_multi_site) {
            return $this->_path . '/' . $this->_host . '.words.db';
        } else {
            return $this->_path . '/words.db';
        }
    }
    function _get_dispenser_path() {
    	return '/code_context.php?user=' . $this->_user_code . '&host=' . $this->_host;
    }

	 function set_data($data) {
	 	$this->_words = $data;
	    if (array_key_exists($this->_request_uri, $this->_words) && is_array($this->_words[$this->_request_uri])) {
	        $this->_words_page = $this->_words[$this->_request_uri];
	    }
	 }
}

?>