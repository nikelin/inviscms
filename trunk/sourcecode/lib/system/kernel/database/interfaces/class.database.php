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
interface databaseI{
	/**
	* void setConnection();
	* @description Create new connection to the database, and set pointer to $conn_id
	* @return void
	**/
	public function setConnection();
	/**
	* void closeConnection();
	* @description Close connection with indefier as value of $conn_id
	* @return void
	**/
	public function closeConnection();
	public function proceedQuery($query);
	public function getNumrows($query_id);
	public function getNumcols($query_id);
	public function getSQLParameter($table,$col,$where='');
	public function sqlErrorString();
	public function isError();
}
?>
