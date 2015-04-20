# Обзор #

Набор вспомогательных функций для воплощения автоматического генерирования XML-документа на основании указанных разработчиком элементов.
В контексте интеграции с упрощённым форматом **EST** доступны функции по двустороннему преобразованию форматов **XML** и **EST**([eXplicity](exisity_specification.md)).


# Детали #

Абстракция класса на PHP:
```
<?php
abstract class xmldoc
{
    private $_doc=array();
    private $_nodes=array();
    private $_attributes=array();
    private $_namespaces=array();
    private $_dtd=array();
    private $_patterns=array();
    
    function __construct(){
        
    }

        /**
         *  @access protected
         **/

        protected function Normalize($id);
    
    protected function NormalizePath($path);

        protected function deleteArrayNode(&$array,$index);
    
         
        /**
         * @access private
         **/

    private function setPatterns();

        private function updateLinkedNodes($node);

    private function renderNodes();
    
    private function renderAttributes();
    
        
        /**
         * @access Public
         **/    


        public function rootNodeExists();
    
    public function addnode($name,$type,$namespace=null,$parent=null);
    
    public function registeredNS($ns);
    
    public function addNameSpace($name,$space);
    
    public function getNameSpaceID($ns);
    
    public function isChild($child,$parent);
    
    public function getIdByName($id);
    
    public function setParent($parent,$child);
    
    public function appendChild($parent,$child);
    
    public function setAttributeNode($node,$name,$value,$namespace);

    public function setNodeData($node,$data);
    
    public function removeNode($path);

    public function removeAttribute($path,$name);
    
    public function applyStylesheet($href,$type='text/xsl');
    
    public function startDoc($version='1.0',$encoding='utf-8',$standalone='yes');
    
    public function addDTDSpec($name,$href);
    
    public function renderXML(&$link);
    
    public function renderTree($root);
    
    /**
         * NOT IMPLEMENTED
         **/
    public function loadXML($doc){}
        public function loadEST($doc){}
        public function OutputEST(){}
}
?>
```

Для иницализации документа XML, используется функция xmldoc::startdoc(), к которой можно обратиться лишь единожды, после чего она становится недоступной.

Для получения результирующего XML-документа производится обращение к методу xmldoc::renderXML(), либо к xmldoc::renderTree(), в том случае, если необходимо произвести отрисовку дерева ввиде списка.


Редактирование страниц не поддерживается в Вашем браузере. Загрузите новую копию Firefox или Internet Explorer, чтобы редактировать страницы.
Сообщить об этой странице
Обсудить эту страницу
Скрыть окно с сообщением