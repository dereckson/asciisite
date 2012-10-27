<?php
/**
 * Template
 *
 * ASCII NFO-like site.
 *
 * (c) 2012, Dereckson, some rights reserved.
 * Released under BSD license.
 *
 * @filesource
 */

/**
 * Lightweight template system
 *
 * A template is HTML file with %%VARIABLE%% substitution.
 */
class Template {
	/**
	 * The template file (suggested extension: .tmpl)
	 *
	 * @var string
	 */
	private $file;

	/**
	 * The template content
	 *
	 * @var string
	 */
	private $source;

	/**
	 * The template variables
	 *
	 * @var Array
	 */
	private $variables;

	/**
	 * Initializes a new Template object
	 *
	 * @param string $file the template file
	 */
	public function __construct ($file) {
		$this->file = $file;
		$this->load();
		$this->variables = array();
	}

	/**
	 * Loads a template
	 */
	public function load () {
		$this->source = file_get_contents($this->file);
	}


	/**
	 * Sets a template variable
	 *
	 * @param string $key the variable name, without enclosing %%
	 * @param string $value the variable value
	 */
	public function set ($key, $value) {
		$this->variables[$key] = $value;
	}

	/**
	 * Gets a template variable
	 *
	 * @param string $key the variable name, without enclosing %%
	 * @return string the variable value
	 */
	public function get ($key) {
		if (array_key_exists($key, $this->variables)) {
			return $this->variables[$key];
		}
		throw new Exception("Unknown variable: $key");
	}

	/**
	 * Determines if a template variable has been defined
	 *
	 * @param string $key the variable name, without enclosing %%
	 * @return Boolean true if the variable has been define; otherwise, false
	 */
	public function hasBeenDefined ($key) {
		return array_key_exists($key, $this->variables);
	}

	//TODO: add a method to check if a variable exists in template source
	//TODO: add a method to get all the variable of the template

        /**
         * Displays the template
         */
	public function display () {
		echo $this;
	}

	/**
	 * Returns the template content
	 */
	public function __toString () {
		$source = $this->source;
		foreach ($this->variables as $key => $value) {
			$source = str_replace("%%$key%%", $value, $source);
		}
		return $source;
	}
}
?>