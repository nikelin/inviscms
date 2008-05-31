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

/**
 * Правила задания заголовка страницы, в контексте данного модуля
 * @return 
 */
function slug()
{
	$result='-> Заказанные футболки';
	$result.=($GLOBALS['basket']->itemsCount()==0)?"-> Корзина футболок пуста":"-> ".$GLOBALS['basket']->itemsCount()." футболок в корзине!";
	return $result;
}

/**
 * Правила задания описания для даннного модуля
 * @return 
 */
function description()
{
}

/***
 * Правила для задания набора ключевых слов для данного модуля
 * @return 
 */
function keywords()
{
}
?>