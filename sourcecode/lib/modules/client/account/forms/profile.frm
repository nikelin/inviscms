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
$q=$database->getRows("accounts","*",array("id"=>$clients->getUID()));
$errors=new Errors();
if(!$database->isError() && $database->getNumrows($q)!=0)
{
	$data=$database->fetchQuery($q);
?>
<script type='text/javascript'>
    <!--
    var tabs = ['person', 'payment', 'password'];
    var showTab = function(e){
        var el = Invis.core.find(tabs, e);
        if (el) {
			document.getElementById('info_part').value=e;
            document.getElementById(tabs[el]).style.display = 'block';
            for (i in tabs) {
                if (i != el) {
                    document.getElementById(tabs[i]).style.display = 'none';
                }
            }
        }
    }
    -->
</script>
<form action='' method='post'>
	<input type='hidden' name='frm_action' value='account'/>
	<input type='hidden' name='info_part' id='info_part' value='person'/>
    <div class='uform' style='width:100%;padding:0;margin:0;margin-top:30px;margin-left:20px;background-color:#ebf8ff;'>
        <div class='legend' style='height:24px;background-color:#FFFFEF;border:1px #000000 dashed;color:#ff5a00;'>
            {^user_info^}
        </div>
        <div class='row' style='margin-bottom:5px;margin-top:5px;'>
            <button onclick='showTab("person");return false;'>
                {^standart_info^}
            </button>
            <button onclick='showTab("payment");return false;'>
                {^payment_info^}
            </button>
            <button onclick='showTab("password");return false;'>
                {^change_password^}
            </button>
        </div>
        <div class='row' style='clear:both;height:auto;'>
            <blockquote id='person'>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^prefered_title^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <select name='title' style='width:100%;'>
                            <option value='0x1'>{^title_mr^}</option>
                            <option value='0x2'>{^title_mrs^}</option>
                            <option value='0x3'>{^title_dear^}</option>
                            <option value='0x4'>{^title_wdear^}</option>
                            <option value='0x5'>{^title_comrad^}</option>
                        </select>
                    </div>
                </div>
                <div class='row' style='height:30px'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^living_country^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <?=$tools->buildList("select","country",array("datasource"=>"countries","label"=>"value","value"=>"id"));?>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^your_fio^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='text' style='width:100%;' name='name'/>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^contact_email^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='text' style='width:100%;' name='email'/>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^contact_phone^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='text' style='width:100%;' name='phone'/>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^delivery_address^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='text' style='width:100%;' name='address'/>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^delivery_method^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <select name='delivery' style='width:100%;'>
                            <option value='0x1'>Курьером (Киев)</option>
                            <option value='0x2'>Наложеным платежом</option>
                            <option value='0x3' selected>Получение товара в нашем офисе</option>
                            <option value='0x4'>Отправка в страны СНГ</option>
                            <option value='0x5'>Отправка в страны Европы и дальнего зарубежья</option>
                        </select>
                    </div>
                </div>
            </blockquote>
            <blockquote id='payment' style='display:none;font-size:14px;'>
                <div class='row'>
                    <strong>{^payment_method^}</strong>
                </div>
                <div class='row' style='text-align:left;'>
                    <span style='display:block'><input type='radio' name='paysys' value='ukrmoney'/>Система онлайн-платежей <a href='http://ukrmoney.com.ua'>UkrMoney</a></span>
                    <span style='display:block'><input type='radio' name='paysys' value='rupay'/>Система онлайн-платежей <a href='http://rupay.ru'>RuPay</a></span>
                    <span style='display:block'><input type='radio' name='paysys' value='cash'>Наличными</span><span style='display:block'><input type='radio' name='paysys' value='banking'>Банковским переводом</span><span style='display:block'><input type='radio' name='paysys' value='post'>Наложеным платежём</span>
                </div>
                <div class='row'>
                    <strong>{^payment_info^}</strong>
                </div>
                <div class='row'>
                    <textarea name='payinfo' style='width:100%;height:50px;'>
                    </textarea>
                </div>
            </blockquote>
            <blockquote id='password' style='display:none;font-size:14px;'>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^your_current_password^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='password' style='width:100%;' name='cpasswd'/>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^your_new_password^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='password' style='width:100%;' name='npasswd'/>
                    </div>
                </div>
                <div class='row' style='height:30px;'>
                    <div class='col' style='text-align:left;width:35%;float:left;'>
                        {^your_retype_password^}:
                    </div>
                    <div class='value' style='width:50%;float:left;'>
                        <input type='password' style='width:100%;' name='npasswd_r'/>
                    </div>
                </div>
            </blockquote>
        </div>
        <div class='submit'>
            <input type='submit' name='action_profile' value='{^save_changes^}'/>
        </div>
    </div>
</form>
<?php
}else
{
	$errors->appendJSError("Ошибка во время диалога с БД!");
}
print $errors->outputData();
?>