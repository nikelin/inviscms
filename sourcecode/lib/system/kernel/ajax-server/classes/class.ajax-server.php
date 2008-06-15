<?php
class ajax_server {
	// Class instances (Singleton)
	public $_instance = null;

	// Methods store
	private $_methods = array ();
	// Debug log
	private $_debug_events = array ();
	// Debug mode
	private $_debug_mode = false;
	// Debug log saving mode
	private $_logging_mode = false;
	// Default variables environment
	private $_default_env = 'POST';
	// Format of resulted data
	private $_results_type = 'xml'; // values: ('est'|'xml'|'post-vars'|'get-vars')


	public function __clone() {
		return null;
	}

	public function getInstance() {
		if (! $this->_instance)
			$classname=__CLASS__;
			$this->_instance=new $classname;
		return $this->_instance;
	}

	/**
	 * Import method to JS-envrinment
	 */

	public function registerMethod($method, $class = null, $class_path = null) {
		if ($class)
			if (class_exists ( $class ) && in_array ( $method, get_class_methods ( $class ) ) )
				if( !self::registered($method))
					self::$_methods[]=array("class"=>$class,"method"=>$method);
			elseif ($class_path)
			{
				require $class_path;
				if (class_exists ( $class ) && in_array( $method, get_class_methods ( $class) ) )
					if( !self::registered($method,$class))
						self::$_methods[]=array("class"=>$class,"method"=>$method);
				else
					throw new AJAXServerError("given classname is not valide or destination class does not content this method");
			}
		else
			if( function_exists($method) )
				self::$_methods[]=array("class"=>null,"method"=>$method);
			else
				throw new AJAXServerError("cannot import unexistance method");
	}

	/**
	* Check is this method was alredy registered
	*/
	private function registered($method,$class=null)
	{
		if( $method && $class )
			foreach(self::$_methods as $k=>$v)
			{
				if( $v['method'] == $method && $v['class'] == $class )
					return true;
			}
		return false;
	}

	/**
	 *
	 * Import class public methods to JS-environment
	 *
	 */

	public function registerClass($class, $path = null) {
		$class=new ReflectionClass($class);
		die_r($class);
	}

	/**
	 * Generate JavaScript alert
	 */

	public function showAlert($text) {

	}

	/**
	 * Ask confirmation and if result is false the call $fFunct()
	 * else call $tFunct() what must be first imported from PHP to
	 * JS-envronment.
	 */
	public function askConfirm($question, $fFunct, $tFunct) {
	}

	/**
	 * Ask user to input some text, and send recived data as
	 * input to the function $reciever()
	 */

	public function askInput($text, $reciever) {

	}

	/**
	 * Redirect user agend to address $path
	 */

	public function redirect($path) {

	}

	/**
	 * Close agent window
	 */

	public function windowClose() {
	}

	/**
	 * Include some JavaScript
	 */

	public function includeScript($path) {

	}

	/**
	 * Get generated JS-code
	 */
	public function getJSCode() {

	}

	/**
	 * Base wrapper function for all requests
	 */
	public function handleRequests() {

	}

	/**
	 * Set on debug mode
	 */
	public function SetDebugMode() {

	}

	/**
	 * Get current debug events history
	 */
	public function getDebugTrace() {

	}

	/**
	 * Set on logging mode
	 */
	public function SetLoggingOn() {
	}

}

$a=new ajax_server();
print $a->
?>