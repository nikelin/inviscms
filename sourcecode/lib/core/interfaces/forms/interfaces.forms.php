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
   interface iforms{
		/**
		 * Append eventHandler to added to form input element
		 * @return integer
		 * @param $name String 
		 * @param $event String
		 * @param $handler String
		 */
		public function addEventHandler($name,$event,$handler);
		
		/**
		 * Add submit control to the form
		 * @return void
		 * @param $name Object
		 * @param $value Object
		 * @param $style Object[optional]
		 */
		public function addSubmit($name,$value,$style='');
		
		/**
		 * Set "important" parameter to the $id - input element
		 * @return integer
		 * @param $name String
		 */
		public function validateElement($id);
		
		/**
		 * Add input element to the current form
		 * @return String 
		 * @param $type String
		 * @param $name String
		 * @param $parent String
		 * @param $id String[optional]
		 * @param $value String[optional]
		 * @param $validate Boolean[optional]
		 * @param $params String[optional]
		 */
		public function addInput($type,$name,$parent,$id='',$value='',$validate=false,$params='');
		
		/**
		 * Add field to the form
		 * @return String 
		 * @param $label String
		 * @param $type String[optional]
		 * @param $el String[optional]
		 * @param $id String[optional]
		 * @param $params String[optional]
		 */
		public function addField($label,$type="pair",$id='',$params="");
		
		/**
		 * 
		 * @return String
		 */
		public function render($output=true);
		public function getData();
		
   }
?>
