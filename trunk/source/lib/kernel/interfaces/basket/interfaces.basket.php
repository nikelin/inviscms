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
interface ibasket{
	
	/**
	 * Append new item to the client basket 
	 *
	 * @param Array $data
	 * @return Boolean
	 */
	public function add($uid,$id);
	
	/**
	 * Get total ordered items cost
	 *
	 * @return Integer
	 */
	public function totalCost($uid);
	
	/**
	 * Get basket items list
	 * 
	 * @return Array
	 */
	
	public function itemsList($uid);
	
	/**
	 * Delete item from the basket
	 *
	 * @param Integer $id
	 */
	
	public function remove($uid,$pid);
	
}
?>