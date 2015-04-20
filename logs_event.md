# Спецификация #

Имя объекта: logs\_event

### Поля объекта: ###
```
  * идентификатор
  * суть_собыятия                                                 
  * текст_события                     
  * время_события                                                
  * автор                                                                
  * состояние_среды                                             
```

### Методы объекта: ###
```
@ Публичные 
  * получить_значение(поле):Булев
  * установить_значение(поле,значение):Булев
@ Защищённые    
  *[нет]*
```

### Описание ###

Объект `*logs_event?*` создаётся каждый раз, когда есть необходимость добавления некоторого информаицонного сообщения к истории системы.

### Информация о поставке ###

Текущая версия пакета: **0.1**
Зависимости:
  * **database**
  * **dirs**