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
$client=$GLOBALS['clients']->getUID();
$client=($client!=-1)?$client:$_SERVER['REMOTE_ADDR'];
?>
<div class="pad">
	<img src="/images/sys/cart.gif" style='margin-left:4px;' alt="My Cart"/>
	<h3 style='margin:0;float:left;'>
		<a href="/basket/view" title="{^my_basket^}">
			{^basket^}
		</a>
	</h3>
    <div class="txt" style='clear:both;'>{^order_amount^}<strong>
            <?=$GLOBALS['basket']->totalCost($client);?>
            грн.</strong><br/>
	    {^count^}:<span style='color:#FF0000;'>
            <?=$GLOBALS['basket']->itemsCount($client);?>
        </span>
    </div>
    <div class='txt' style='margin:0;padding:0;margin-left:4px;color:#000000;'>
	<span onclick='window.location.href="/order";return false;' style='text-align:center;cursor:pointer;font-weight:bold;font-size:11px;'>
	    {^order^}
	</span>
	<span onclick='window.location.href="/basket/view";return false;' style='text-align:center;cursor:pointer;font-weight:bold;font-size:11px;'>
	    {^view_basket^}
	</span>
    </div>
</div>