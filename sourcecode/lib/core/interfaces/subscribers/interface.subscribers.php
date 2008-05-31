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
   class subscribers{
   	 	
		/**
		 * Add user to subscribers list
		 * @return 
		 * @param $email Object
		 */
		public function addUser($email);
		
		/**
		 * Activate $email-address
		 * @return 
		 * @param $email Object
		 */
		public function activateAddress($email);
		
		/**
		 * Do not send mails to the subscriber with email=$email
		 * @return 
		 * @param $email Object
		 */
		public function stopSending($email);

		
		/**
		 * Check that client still want to recieve mails
		 * @return 
		 * @param $email Object
		 */
		public function ping($email);
		
		/**
		 * Is $email-address exists ?
		 * @return 
		 * @param $email Object
		 */
		public function checkExistance($email);
		
   }
?>
