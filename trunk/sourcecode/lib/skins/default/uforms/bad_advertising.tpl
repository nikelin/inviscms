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
?><div id='regForm client_form' style='background-color:#FFFFFF;color:#000000;width:450px;position:absolute;left:33%;top:38%;'>
			<div class='logo' style='height:25px;font-weight:bold;text-align:center;margin-bottom:10px;background-color:#FFFFCF;font-size:20px;'>
				<span style='width:95%;float:left;' class='title'>{^uncompitable_advertising^}</span>
				<span style='display:block;float:left;cursor:pointer;background-color:#FFFFFF;color:inherit;width:20px;' class='close' onclick='Invis.tools.changeElVis("reg_form","off");'><u>X</u></span>
			</div>
			<div class='row' style='clear:both;height:25px;margin-left:15px;'>
				<div class='label' style='display:block;float:left;margin-left:4px;margin-right:5px;width:30%;'>{^feedback_subject^}:</div>
				<div class='value' style='display:block;float:left;width:60%;'>
					<input type='text' id='subject' style='width:100%;'/>
				</div>	
			</div>
			<div class='row' style='clear:both;height:25px;margin-left:15px;'>
				<div class='label' style='display:block;float:left;margin-left:4px;margin-right:5px;width:30%;'>{^your_fio^}:</div>
				<div class='value' style='display:block;float:left;width:60%;'>
					<input type='text' id='name' style='width:100%;'/>
				</div>	
			</div>
			<div class='row' style='clear:both;height:25px;margin-left:15px;'>
				<div class='label' style='display:block;float:left;margin-left:4px;margin-right:5px;width:30%;'>{^contact_info^}:</div>
				<div class='value' style='display:block;float:left;width:60%;'>
					<input type='text' id='contacts' style='width:100%;'/>
				</div>	
			</div>
			<div class='submit' style='text-align:center;background-color:#000000;margin-top:5px;'>
				<input type='submit' name='send' value='{^inform^}'/>
			</div>
		</div>