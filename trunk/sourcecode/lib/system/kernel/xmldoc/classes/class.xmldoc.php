<?php
class  xmldoc
{
	
	private $_doc=array();
	private $_nodes=array();
	private $_attributes=array();
	private $_namespaces=array();
	private $_dtd=array();
	private $_patterns=array();
	
	public function __construct(){
		
	}
	
	private function setPatterns()
	{
		$this->_patterns['ns']='([a-z_]{1,1}[a-zA-Z0-9_]*)+';
		$this->_patterns['node']='([a-zA-Z_-]{1,1}[a-zA-Z0-9_]*)+';
	}
	
	public function rootNodeExists()
	{
		return (false!==($this->_root_node));
	}
	
	public function addnode($name,$type,$namespace=null,$parent=null)
	{
		if($namespace)
		{
			try{
				$ns=&$this->_namespaces[$this->getNameSpaceId($namespace)];
			}catch(XMLNameSpaceError $e)
			{
				throw new XMLNodeError("invalid namespace given");
			}
		}
		if(!$parent){
			if($this->rootNodeExists()) 
			{
				throw new XMLNodeError("root alredy exists");
			}else	
			{	
				$this->_nodes[]=array("name"=>$name,"type"=>$type,"childs"=>array(),"atts"=>array(),"ns"=>$ns,"parent"=>null);
				$this->_root_node=count($this->_nodes)-1;
			}
		}else{
			$id=count($this->_nodes)-1;
			$this->_nodes[$id]=array("name"=>$name,"type"=>$type,"ns"=>&$ns,"childs"=>array(),"atts"=>array(),"parent"=>&$this->_nodes[$parent]);
			try{	
				$this->appendChild($parent,$id);
			}catch(XMLNodeError $e)
			{
				throw new XMLNodeError("impossible to append child node `".$child."` to `".$parent."`");
			}
		}			
	}
	
	public function registeredNS($ns)
	{
		return (is_numeric($ns) && $ns<(count($this->_namespaces)-1));
 	}
	
	public function addNameSpace($name,$space)
	{
		if(preg_match('/'.$this->_patterns['ns'].'/',$ns) && trim($space)!='')
			$this->_namespaces[]=array('name'=>$name,"space"=>$space);
		else throw new XMLNSpaceError("wrong namespace identifier or empty linked space");		
	}
	
	public function getNameSpaceID($ns)
	{
		if(is_numeric($ns) && $this->registeredNS($ns)) return $ns;
		else
		{
			$e=null;
			for($i=0;$i<count($this->_namespaces);$i++)
			{
				if($this->_namespaces[$i]['name']==$ns)
				{
					$e=$id;
				}
			}
			if(false!==($e)) return $e;
			else throw new XMLNameSpaceError("namespace is not exists");
		}
	}
	
	public function Normalize($id)
	{
		if(is_numeric($id) && $id<(count($this->_nodes)-1))
		{
			return $id;
		}
		try{
			return $this->NormalizePath($id);
		}catch(XMLPathNormalizingError $e)
		{
			throw new XMLNormalizingError("node or path `".$id."` is not exists");
		}
	}
	
	protected function NormalizePath($path)
	{
		$result=null;
		if(trim($path)!='')
		{
			$path=explode('/',$path);
			if(count($path)==1)
			{
				 return $this->rootNodeId();
			}else
			{
				$curr=$this->rootNodeId();
				for($i=0;$i<count($path);$i++)
				{
					try{
						if($this->isChild($curr,$path[$i]))
						{
							$curr=$path[$i];
						}else
						{
							throw new XMLLinkingError("broken node in path link");
							break;
						}
					}catch(XMLLinkingError $e)
					{
						throw new XMLLinkingError("broken node in path link");
					}
				}
				$result=$curr;
			}
		}
		return $result;
	}
	
	public function isChild($child,$parent)
	{
		if(is_numeric($child) && is_numeric($parent))
		{
			if($child<count($this->_nodes[$parent]['childs']))
			{
				for($i=0;$i<count($this->_nodes[$parent]['childs']);$i++)
				{
					if($i==$child)
					{
						return true;
					}
				}
			}else
			{
				return false;
			}
		}
	}
	
	public function getIdByName($id)
	{
		if(is_numeric($id)) return $id;
		else
		{
			for($i=0;$i<count($this->_nodes);$i++)
			{
				if($this->_nodes['name']==$id) return $i;
			}
		}
		return null;
	}
	
	public function setParent($parent,$child)
	{
		
	}
	
	public function appendChild($parent,$child)
	{
		try{
			$parent=$this->NormalizeIdentifier($parent);
			$child=$this->NormalizeIdentifier($child);
		}catch(XMLNormalizingError $e)
		{
			 throw new XMLNodeError("invalid node(s) ID");
		}
		if($parent!=$child)
		{
			$this->_nodes[$parent]['childs'][]=&$this->_nodes[$child];
			$this->_nodes[$child]['parent']=&$this->_nodes[$parent];
		}else throw new XMLLinkingError("node cannot be a self child");
	}
	
	
	public function setAttributeNode($node,$name,$value,$namespace)
	{
		try{
			$id=$this->Normalize($nodes);
		}catch(XMLNormalizingError $e)
		{
			throw new XMLNodeError("invalide node(s) ID");
		}
		if(trim($name)!='')
		{
			throw new XMLAttributeError("attribute name MUST NOT be empty");
		}else
		{
			try{
				$ns=$this->getNameSpaceId($namespace);
			}catch(XMLNameSpaceError $e)
			{
				throw new XMLAttributeError("wrong namespace given");
			}
			$id=count($this->_attributes)-1;
			$this->_attributes[$id]=array("node"=>&$this->_nodes[$node],"name"=>$name,"value"=>$value,"namespace"=>&$this->_namespaces[$ns]);
			$this->_nodes[$node]['attributes'][]=&$this->_attributes[$id];
		}
	}
	
	public function setNodeData($node,$data)
	{
		try{
			$node=$this->Normalize($node);	
		}catch(XMLNormalizingEror $e)
		{
			throw new XMLNodeError("invalide node identifier");
		}
		if($this->isPairNode($node))
		{
			$this->_nodes[$node]['data']=$data;
		}
	}
	
	public function removeNode($path)
	{
		try
		{
			$path=$this->NormalizePath($path);
		}catch(XMLNormalizingError $e)
		{
			throw new XMLNodeError("impossible to normalize path to destination node");
		}
		try
		{
			$this->updateLinkedChilds($path);
			$this->updateLinkedParents($path);
		}catch(XMLLinkingError $e)
		{
			throw new XMLNodeError("couldn't update nodes linked with deleted node");
		}
		$this->deleteArrayNode(&$this->_nodes,$path);
	}
	
	public function updateLinkedNodes($node)
	{
		try{
			$node=$this->Normalize($node);
		}catch(XMLNormalizingError $e)
		{
			throw new XMLLinkingError("invalide node identifier given");
		}
		for($i=0;$i<count($this->_nodes);$i++)
		{
			if($this->_nodes[$i]['parent']==$node)
			{
				$this->_nodes[$i]['parent']=null;
			}else{
				for($j=0;$j<count($this->_nodes[$i]['childs']);$j++)
				{
					if($j==$node)
					{
						try{
							$this->deleteArrayNode(&$this->_nodes[$i]['childs'],$j);
						}catch(ArrayNodeError $e)
						{
							throw new XMLInternalError("wrong array struture");
						}
					}
				}
			}
		}
	}
	
	public function deleteArrayNode(&$array,$index)
	{
		if(is_array($array) && in_array($index,$array))
		{
			$tmp_nodes=array();
			for($i=0;$I<count($array);$i++)
			{
				if($i!=$path)
				{
					$tmp_nodes[]=$array[$i];
				}
			}
			$array=$tmp_nodes;
		}else
		{
			throw new ArrayNodeError("invalide array structures");
		}
	}
	
	public function removeAttribute($path,$name)
	{
		try{
			$node=$this->Normalize($path);
		}catch(XMLNormilizingError $e)
		{
			throw new XMLAttributeError("destination attribute path (`".$path."`) is not exists");
		}
		try
		{
			$ob=&$this->_nodes[$path]['attributes'];
			for($i=0;$i<count($ob);$I++)
			{
				if($ob[$i]['name']==$name)
				{
					$this->deleteArrayNode($ob,$i);
				}
			}
		}catch(XMLInternalError $e)
		{
			throw new XMLAttributeError("attribute deleting error");
		}
	}
	
	public function applyStylesheet($href,$type='text/xsl')
	{
		$this->_doc['stylesheet']=array("href"=>$href,"type"=>$type);
	}
	
	public function startDoc($version='1.0',$encoding='utf-8',$standalone='yes')
	{
		if($this->_started)
		{
			$this->_doc['version']=$version;
			$this->_doc['encoding']=$encoding;
			$this->_doc['standalone']=$standalone;
		}else
		{
			throw new XMLDocError("document alredy initialized");
		}
	}	 
	
	public function addDTDSpec($name,$href){}
	
	public function renderXML(&$link)
	{
		
	}
	
	public function renderNodes()
	{
		
	}
	
	public function renderAttributes()
	{
		
	}

	
	public function renderTree($root)
	{
		/**
		$result="<ul>";
		$data=($root)?$this->_nodes[$root]:
		for($i=0;$i<count($this->_nodes);$i++){
			if($this->_nodes[$i]['root']){
				$result="<li>Root: ".$this->_nodes[$i]['name']."</li>";
			}else
			{
				$result="<lI>".$this->_nodes[$i]['name'].$this->rednerTree
			}
		}
		$result="</ul>";
		**/
	}
	
	/**
	 * Parser constructor implementing
	 * @return Array
	 */
	public function loadXML(){}

}
 ?>