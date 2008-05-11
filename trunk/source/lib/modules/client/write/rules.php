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
	$result='Контакты -> Отправка сообещния';
	return $result;
}

/**
 * Правила задания описания для даннного модуля
 * @return 
 */
function description()
{
	$result='Страница для отправки сообщения в администрацию магазина футболок ФутболкаPrint&copy; с помощью специальной формы отправки';
	return $result;
}

/***
 * Правила для задания набора ключевых слов для данного модуля
 * @return 
 */
function keywords()
{
	$result='отправка сообщение футболки уведомление письмо служба поддержки контакт связь админстрация магазина';
	return $result;
}
?>