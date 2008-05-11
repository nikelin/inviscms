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
		public function addUser($email)
		{
			$tools=&$GLOBALS['tools'];
			$database=&$GLOBALS['datababase'];
			
			if($tools->valideEmail($email) && !$database->checkExists("subscribers",array("email"=>$email)))
			{
				if(!$database->inserRow('subscribers',array(
														array('name'=>'id','value'=>'LAST_INSERT_ID()','type'=>'funct'),
														array('name'=>'from','value'=>$_SERVER['HTTP_REFERER'],'type'=>'text'),
														array('name'=>'ip','value'=>$_SERVER['REMOTE_ADDR'],'type'=>'text'),
														array('name'=>'date','value'=>time(),'type'=>'text'),
														array('name'=>'email','value'=>$email,'type'=>'text'),
														array('name'=>'status','value'=>'','type'=>'text'),
														array('name'=>'state','value'=>'','type'=>'text'))))
				{
					return DATABASE_PROCEED_ERROR;
				}else
				{
					$this->_waitActivation($email);
				}
			}else{
				return MAILLIST_WRONG_PARAMS;
			}
		}
		
		/**
		 * Activate $email-address
		 * @return 
		 * @param $email Object
		 */
		public function activateAddress($email)
		{
			$tools=$GLOBALS['tools'];
			$database=$GLOBALS['datababase'];
			
			if($tools->valideEmail($email) && $database->checkExists("subscribers",array("email"=>$email)))
			{
				if(!$database->updateRow("subscribers",array("email"=>$email),array("state"=>"activated")))
				{
					return DATABASE_PROCEED_ERROR;
				}else
				{
					if(!$database->deleteRow("temp",array("body"=>md5($email))))
					{
						return DATABASE_PROCEED_ERROR;
					}
				}
			}
			return 1;
		}
		
		/**
		 * Send activation request to $email-address
		 * @return 
		 * @param $email Object
		 */
		private function _waitActivation($email)
		{
			$tools=$GLOBALS['tools'];
			$database=$GLOBALS['datababase'];
			if($tools->validateEmail($email) && $database->checkExists("subscribers",array("email"=>$email)))
			{
				$q=$database->insertRow("temp",array(
														array('name'=>'id','value'=>"LAST_INSERT_ID()","type"=>"text"),
														array('name'=>'body','value'=>md5($email),'body'=>time())
													));
				$q1=$database->updateRow("subscribers",array("email"=>$email),array("state"=>"notactivate"));
				if(!$q || !$q1)
				{
					return DATABASE_PROCEED_ERROR;
				}
			}else{
				return MAILLIST_WRONG_PARAMS;
			}
			return 1;
		}
		
		/**
		 * Do not send mails to the subscriber with email=$email
		 * @return 
		 * @param $email Object
		 */
		public function stopSending($email){
			
		}
		
		/**
		 * Check that client still want to recieve mails
		 * @return 
		 * @param $email Object
		 */
		public function ping($email){}
		
		/**
		 * Is $email-address exists ?
		 * @return 
		 * @param $email Object
		 */
		public function checkExistance($email){}
		
   }
?>
