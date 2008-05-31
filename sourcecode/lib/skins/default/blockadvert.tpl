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
?><?=$GLOBALS['html']->topRounded("100%","margin-top:5px;");?>
					<div class='container' style='height:80px;'>
						<div class='advertText' style='height:15px;margin:0;clear:left;'>
							{^advertising^} 
								- 
								<a href='/advertising' title='{^order_advertising^}'>{^order_advertising^}</a> 
						</div>
						<div style='display:block;width:100%;text-align:center;height:70px;clear:both;'>
						<noindex>
							<!-- Ukrainian Banner Network 468x60 START -->
							<script>
							//<!--
							user = "56203";
							page = "1";
							for(var i=0;i<2;i++)
							{
								pid = Math.round((Math.random() * (10000000 - 1)));
								document.write("<iframe src='http://banner.kiev.ua/cgi-bin/bi.cgi?h" +
								user + "&amp;"+ pid + "&amp;" + page + "' frameborder=0 vspace=0 hspace=0 " +
								" width=468 height=60 marginwidth=0 marginheight=0 scrolling=no>");
								document.write("<a href='http://banner.kiev.ua/cgi-bin/bg.cgi?" +
								user + "&amp;"+ pid + "&amp;" + page + "' target=_top>");
								document.write("<img border=0 src='http://banner.kiev.ua/" +
								"cgi-bin/bi.cgi?i" + user + "&amp;" + pid + "&amp;" + page +
								"' width=468 height=60 alt='Украинская Баннерная Сеть'></a>");
								document.write("</iframe>");
							}
							//-->
							</script>
						</noindex>
			</div>
</div>
<?=$GLOBALS['html']->bottomRounded();?>