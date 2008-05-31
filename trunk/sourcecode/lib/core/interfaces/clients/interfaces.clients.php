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
interface iclients{
	
	/**
	 * Get client unque identifier
	 *
	 * @return Integer
	 */
	public function getUID();
	
	/**
	 * Check is visitor registered client
	 *
	 * @return Boolean
	 */
	public function isClient();
	
	/**
	 * Create new client account
	 *
	 * @param Array $data
	 */
	public function addClient($data=array());
	
	/**
	 * Change client account status (enable or disable)
	 *
	 * @param Integer $id
	 * @param Boolean $status
	 */
	public function changeStatus($id,$status);
	
	/**
	 * Get last operation what making client under account
	 *
	 * @param Integer $uid
	 */
	public function getHistory($uid);
	
}
?>