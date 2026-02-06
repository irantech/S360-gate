<?php

/**
 * Class Load
 * @property Load $Load
 */

class Load
{


    static function autoload($class)
    {

        if (file_exists(LIBRARY_DIR . $class . '.php')) {
            require_once LIBRARY_DIR . $class . '.php';
        } elseif (file_exists(CONTROLLERS_DIR . $class . '.php')) {
            require_once CONTROLLERS_DIR . $class . '.php';
        }


    }
	
	/**
	 * @param $class
	 *
	 * @return mixed|Model|ModelBase
	 */
	static function library($class)
    {

        require_once LIBRARY_DIR . $class . '.php';

        return new $class();
       
    }
	
	/**
	 * @param $class
	 *
	 * @return mixed|application
	 */
	static function Config($class)
    {

        require_once CONFIG_DIR . $class . '.php';
        return new $class();

    }
	
	/**
	 * @param $modelName
	 *
	 * @return mixed|boolean
	 */
	static function model($modelName)
    {

        $file = MODEL_DIR . $modelName . '.php';
        if (file_exists($file)) {
            require_once $file;
            $model = $modelName . '_tb';

            $call_name = new $model();

            return $call_name;
        }
        return false;
    }
	
	
	/**
	 * @param $modelName
	 *
	 * @return boolean|mixed
	 */
	static function getModel($modelName)
    {

        $file = MODEL_DIR . $modelName . '.php';
        if (file_exists($file)) {
            require_once $file;
            $model = $modelName;
            return new $model();
        }
        return false;
    }

    /**
     * @param $controllerName
     * @param null $param
     * @return bool|admin|mixed
     */
	static function controller($controllerName,$param=null)
    {
      
        $file = CONTROLLERS_DIR . $controllerName . '.php';
        if (file_exists($file)) {
            require_once $file;
            $controller = $controllerName . 'Controller';
           if (!class_exists($controller, FALSE)) {
                $controller = $controllerName;
            }
            return new $controller($param);

        }else  if (file_exists($file = CONTROLLERS_DIR.'customers/'. $controllerName . '.php')) {
            require_once $file;
            $controller = $controllerName . 'Controller';
            if (!class_exists($controller, FALSE)) {
                $controller = $controllerName;
            }
            return new $controller($param);

        } else {
            $file = CONTROLLERS_DIR_APP . $controllerName . '.php';
            if (file_exists($file)) {
                require_once $file;
                $controller = $controllerName;
                return new $controller($param);
            }
            return false;
        }
    }
	
	/**
	 * @param $array
	 *
	 * @return string
	 */
	static function plog($array)
    {

        echo  '<pre>' . print_r($array, true) . '</pre>';
    }
	
	
	/**
	 * @param $controllerName
	 *
	 * @return bool
	 */
	static function controllerWithParams($controllerName)
    {

             $file = CONTROLLERS_DIR . $controllerName . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
            return false;

    }

}
