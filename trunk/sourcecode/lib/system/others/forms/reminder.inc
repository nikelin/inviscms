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
function reminder_main($e=null)
{
    $result=0;
    $tools=&$GLOBALS['tools'];
    $mail=&$GLOBALS['mail'];
    $database=&$GLOBALS['database'];
    
    $part=isset($GLOBALS['params']['params'][1])?$GLOBALS['params']['params'][1]:null;
    if(!$part)
    {
        $result=0;
    }else
    {
        $data=$tools->getEnvVars("POST",true);
        swtich($part)
        {
            case 'email':
                if(isset($data['email']) && $tools->isEmail($data['email']))
                {
                    if($uid=$database->checkRowExists("clients",array("email"=>$data['email'])))
                    {
                        if($security->initPasswdChg($uid))
                        {
                            $result=200;
                        }
                    }
                }
                break;
            case 'personal':
                $data=$tools->getEnvVars("POST",true);
                if(count($data)!=0)
                {
                    $q=$database->insertRow("accessrestore",array("",serialize($data),$_SERVER['REMOTE_ADDR'],time(),"active");
                    if(!$database->isError())
                    {
                        $result=200;
                    }
                }
                break;       
        }
    }
    return $result;
}
function reminder_success()
{
    $errors=new Errors();
    $errors->appendJSError("Запрос успешно отправлен. В ближайшее время вы получите ответ!");
    return $errors->outputData();
}
function reminder_error()
{
    $errors=new Errors();
    $errors->appendJSError("Ошибка во время проверки запроса!");
    return $errors->outputData();
}
?>