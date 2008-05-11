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
class invisparser implements iinvisparser {
    private $_start='';
    private $_version=1.0;
    private $_compiler=null;
    
    function __construct(){
		$this->_start=time();
		if(!class_exists('inviscompiler'))
		{
		    die("InvisParser initializing error!");
		}else{
		    $this->_compiler=new inviscompiler();
		}
		$this->_compiler->setPath("tmpls",'');
		//$this->_checkEnvironment_directories();
	 	//$this->initializeEnvironmentVariables();
    }

    private function _checkEnvironment_directories(){
	if(!file_exists($this->_tmpl_path)){
		$this->setError('Cannot reach directory with templates !','critical',$this->getErrorInfo(__LINE__,__FILE__));
	}
    }
    

    private function initializeEnvironmentVariables(){
    	$this->environment_assign('TMPL_PATH',$this->_tmpl_path);
	$this->environment_assign('DEGUB_MODE',$this->_debug);
	$this->environment_assign('PHP_FUNCTIONS_IMPORT',$this->_import_php_function);
	$this->environment_assign('OUTPUT_TO_FILE',$this->_output_to_file);
	$this->environment_assign('OUTPUT_DOCUMENT',$this->_output_document);
	$this->environment_assign('INVIS_VERSION',$this->_version);
	$this->environment_assign('TAGS_PATH',$this->_tags_path);
	$this->environment_assign('CONFIG_PATH',$this->_config_path);
	$this->environment_assign('FUNCTION_IGNORE_LIST',$this->_functions_ignore_list);
	//$this->environment_assign('PROCEED_TIME',($this->_start-time()));
    }

    public function make_tpl_include($env_name,$tpl){
    	if(trim($env_name)!='' && trim($tpl)!=''){
    		if(array_key_exists($env_name,$this->_included_tpls)===false){
    			$this->_included_tpls[$env_name]=$tpl;
    		}else{
    			$this->setError('This variable alredy defined !','notice',$this->getErrorInfo(__LINE__,__FILE__));
    		}
    	}else{
    		$this->setError('Error while checking input arguments !','warn',$this->getErrorInfo(__LINE__,__FILE__));
    	}
    }

    public function assign_by_ref($env_name,$php_name){
        if(isset($$php_name)){
            if(array_search($this->_variables,$env_name)===false){
                if(trimdir($env_name)!=''){
                    $this->_variables[$env_name]=&$php_name;
                }else{
                    $this->setError('Variable must have name!','warn',$this->getErrorInfo(__LINE__,__FILE__));
                }
            }else{
                $this->setError('Variable `'.$env_name.'` is alredy registered !','notice',$this->getErrorInfo(__LINE__,__FILE__));
            }
        }else{
            $this->setError('Variable `'.$php_name.'` is not exists in the PHP environment !','warn',$this->getErrorInfo(__LINE__,__FILE__));
        }
    }

    public function assign($name,$value){
        if(!$this->_compiler->_variable_exists($name)){
            if(trim($name)!=''){
                $this->_compiler->newVariable($name,$value);
            }
        }
    }

    public function function_assign($env_name,$php_name){
        if(function_exists($php_name)){
            if(array_search($this->_variables,$env_name)===false){
                if(trim($env_name)!=''){
                    $this->_functions[$env_name]=$php_name;
                }else{
                    $this->setError('Function must have name !','warn',$this->getErrorInfo(__LINE__,__FILE__));
                }
            }else{
                $this->setError('Function is alredy registered !','warn',$this->getErrorInfo(__LINE__,__FILE__));
            }
        }else{
            $this->setError('Function is not exists in the PHP environment !','warn',$this->getErrorInfo(__LINE__,__FILE__));
        }
    }

    public function array_assign_by_ref($env_name,$php_name){
        if(isset($$php_name)){
            if(trim($env_name)!=''){
                if(isset($this->_arrays[$env_name])){
                    $this->setError('This array alredy registered !','notices',$this->getErrorInfo(__LINE__,__FILE__));
                }else{
                    $this->_arrays[$env_name]=&$php_name;
                }
            }else{
                $this->setError('Variable must have name in the environment!','warn',$this->getErrorInfo(__LINE__,__FILE__));
            }
        }else{
            $this->setErorr('Variable not exists in the PHP environment !');
        }
    }

    public function array_assign($name,$value){

    }

    public function element_append($name,$value,$index=''){

    }

    public function tag_assign($tag)
    {
    	if(trim($tag)!='')
    	{
			if(!array_search($tag,$this->_tags))
			{
				if($this->checkTagExists($tag))
				{
					if($this->_checkTagConsistance($tag)){
						$this->_tags[]=$tag;
					}else{
						$this->setError('Error while check object consistance !'.$this->_getTagConsistanceError($tag),'critical',$this->getErrorInfo(__LINE__,__FILE__));
					}
				}
				else
				{
					$this->setError('Impossible to load plugin executable !','critical',$this->getErrorInfo(__LINE__,__FILE__));
				}
			}
	}else{
		//
	}
    }

    //Implementation need
    function checkAuthority(){
    	//Body of function
    }

    function writeOutputToFile(){
    	if(trim($this->_output_document)!=''){
    		if(!$this->temp['_fp']=@fopen($this->_output_document,'w+')){
    			$this->setError('Error while attempt to open output file !','warn',$this->getErrorInfo(__LINE__,__FILE__));
    		}else{
    			@flock($this->temp['_fp'],LOCK_EX);
    			if(!@fwrite($this->temp['_fp'],$this->_output_data)){
    				$this->setError('Error while attempt to write output to file !','warn',$this->getErrorInfo(__LINE__,__FILE__));
    			}
    			@flock($this->temp['_fp'],LOCK_UN);
    			@fclose($this->temp['_fp']);
    		}
    	}else{
    		$this->setError('Output document not setted !','warn',$this->getErrorInfo(__LINE__,__FILE__));
    	}
    }

    function outputData(){
	if($this->_compiler->rendered)
	{
	    if($this->_output_to_file)
		$this->writeOutputToFile();
	    else
		return $this->_output_data;
	}
    }

    function ignore_function($function_name){
	if(trim($function_name)!=''){
		if(!array_search($function_name,$this->_ignore_list)){
			$this->_ignore_list[]=$function_name;
		}
	}else{
		$this->setError('Cannot find name of function to ignore !','notice',$this->getErrorInfo(__LINE__,__FILE__));
	}
    }

    function phpWrapper($text){
     ob_start();
    # $text=str_replace('<'.'?php','<'.'?',$text);
   # die_r($text);
     eval('?>'.trim($text));
     $content=ob_get_contents();
     ob_end_clean();
     return $content;
    }
    
    function display($data){
    	return $this->_compiler->Render($data);
    }

    function fetch($tpl_name){
		$data=$this->_compiler->Render($tpl_name,"link");
		#$this->saveCache($this->getTpl($this->_current_tpl));
		return $this->phpWrapper($data);
    }
}
?>