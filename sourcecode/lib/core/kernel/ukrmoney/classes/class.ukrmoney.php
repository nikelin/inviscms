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
class ukrmoney extends payment{
	private $_session=null;
	private $_error=null;
	private $_opstatus=null;
	private $base_curr='uah';
	private $currs=array();
	private $mainAccount=array('login'=>"",'passwd'=>"");
	private $host="api.ukrmoney.com";
	
	public function setBaseCurrency($val)
	{
		if(in_array($val,$this->currs))
			$this->base_curr=$this->currs[$val];
	}
	
	function __construct($login="",$passwd="")
	{
		if(trim($login)!='' && trim($passwd)!=''){
			$this->mainAccount['login']=$login;
			$this->mainAccount['passwd']=$passwd;
		}
	}
	
	public function init()
	{
		$csc=&$GLOBALS['csc'];
		$result=false;	
		if($csc->openConnection($this->host,"http",80)){
			$result=true;
		}
		return $result;
	}
	
	public function auth($login,$passwd)
	{
		$result=null;
		$this->mainAccount['login']=$login;
		$this->mainAccount['passwd']=$passwd;
		if($this->authorize()){
			$result=true;
		}
		return $result;
	}
	
	public function authorize()
	{
		$result=null;
		$csc=&$GLOBALS['csc'];
		if($this->init()){
			$csc->sendQuery("GET","/login/?u_mail=".$this->mainAccount['login']."&u_pwd=".$this->mainAccount['passwd']);
			$result=$csc->readAnswer(true);
			die_r($result);
			if(false===($result=$this->getVars("login",$result))) $result=false;
			$csc->closeConnection();
		}
		return $result;
	}
	
	private function getVars($operation,$data){
		$result=false;
		#die_r($data);
		$dat=simplexml_load_string($data);
		if($data){
			switch($operation)
			{
				case 'login':
					if(!@$dat->session){
						$this->_error=(String)$dat[0];	
					}else{
						$this->_session=(String)$dat->session;
						
						$result=true;
					}
					break;
				case 'newtrans':
					if($dat[0]!='ok'){
						$this->_error=(String)$dat[0];
					}else{
						$this->_opstatus=(String)$dat[0];
						$result=true;
					}
					break;
				case 'balance':
	  				$result=array();
	  				for($i=0;$i<count($dat->purse);$i++)
	  				{
	  					$ob=&$dat->purse[$i];
	  					$result[]=array(
	  								'id'=>(String)$ob->id,
	  								'number'=>(String)$ob->number,
	  								'currency'=>(String)$ob->currency,
	  								'name'=>(String)$ob->name,
	  								'amount'=>(String)$ob->amount);
	  				}
	  				break;
				case 'trans_list':
					$result=array();
					die_r($dat);
					for($i=0;$i<count($dat->transaction);$i++)
					{
						$ob=&$dat->transaction[$i];
						$result[]=array(
									'type'=>(String)$ob->type,
									'user_email'=>(String)$ob->user_email,
									'user_purse'=>(String)$ob->user_purse,
									'my_purse'=>(String)$ob->my_purse,
									'my_purse_amnt_before'=>(String)$ob->my_purse_amnt_before,
									'amnt'=>(String)$ob->amnt,
									'fee'=>(String)$ob->fee,
									'word'=>(String)$ob->word,
									'time'=>(String)$ob->time
								);
					}
					break;
				default:break;
			}
		}
		return $result;
	}
	
	public function getError(){
		return $this->_error;
	}
	
	public function makeTransaction($recipient,$amount,$goal="")
	{
		$csc=&$GLOBALS['csc'];
		$result=false;
		if($this->authorize()){
				if($csc->sendQuery("GET","/newtrans/?pcsl_session_id=".$this->_session.
									"&t_benef_mail=".$recipient.
									"&t_currency=".$this->base_curr.
									"&t_benef_order=3".
									"&t_amnt=".$amount.
									"&t_wording=".rawurlencode($goal))){
										$result=$csc->readAnswer(true);
										if(!$this->getVars("newtrans",$result)) $result=false;
									}
		}
		$csc->closeConnection();
		return $result;
	}
	
	
	public function getOpStatus(){return $this->_opstatus;}
	
	public function deleteLeadZero($data)
	{
		$data=preg_match_all("/[0]*([0-9]*)/",$data,$r);
		return $r[1][0];
	}
	
	public function transactions_list($account,$start_date="",$stop_date="")
	{
		$csc=&$GLOBALS['csc'];
		$result=false;
		if($this->init()){
			#die_r($this->_session);
			if($csc->sendQuery("GET","/trans_list/?pcsl_session=".$this->_session.
								"&p_um=48351"))
			{
				$result=$csc->readAnswer(true);
				die_r($result);
				$result=$this->getVars("trans_list",$result);
			}
		}
		return $result;
	}
	
	public function balance()
	{
		$csc=&$GLOBALS['csc'];
		$result=false;
		if($this->init()){
			if($csc->sendQuery("GET","/balance/?pcsl_session_id=".$this->_session))
			{
				$result=$csc->readAnswer(true);
				$result=$this->getVars("balance",$result);
			}
			$csc->closeConnection();
		}
		return $result;
	}
	
	public function logout()
	{
		
	}
	
}
?>
