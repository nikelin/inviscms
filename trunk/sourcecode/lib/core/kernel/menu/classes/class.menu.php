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
class menu implements menuI
{
        public $output='';
        private $instances=array();

        function __construct()
        {
                global $instances;
                if(is_array($instances) && count($instances)>0){
                        $this->instances=&$instances;
                }

        }

        function makeInstance($type,$class='')
        {
                if(is_string($type)){
                        $this->type=$type;
                        switch($this->type){
                                case 'list':
                                default:
                                        $this->output.='<div ';
                                        if(trim($class)!=''){
                                                $this->output.='class="'.$class.'" ';
                                        }
                                        $this->output.='>';
                                        $this->output.='<ul>';
                                break;
                }

        }else{
                die("Wrong menu type requested !");
        }
        return($this);
        }

        function appendElement($href,$text,$title,$class='')
        {
                switch($this->type){
                        case 'list':
                        default:
                                $this->output.='<li ';
                                if(trim($class)!=''){
                                        $this->output.='class="'.$class.'" ';
                                }
                                $this->output.='>';
                                $this->output.='<a href="'.$href.'" title="'.$title.'"><span>'.$text.'</span></a>';
                                $this->output.='</li>';
                                break;
                }
        }

        function outputData()
        {
                $this->output.='</ul></div>';
                return $this->output;
        }
}
?>
