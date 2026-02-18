<?php
// Plug-in functions inside plug-in files must be named: smarty_type_name
function smarty_function_load_presentation_object($params, $smarty)
{
	 $file= !empty($params['subName']) ?  CONTROLLERS_DIR. $params['subName'] .'/'. $params['filename'] . '.php' : CONTROLLERS_DIR . $params['filename'] . '.php';


	if(is_file($file)){ require_once $file;}
	else {// $file=COMPONENTS_DIR . $params['filename'] . '.php'; 
		$file=LIBRARY_DIR . $params['filename'] . '.php';
		require_once $file;
	}

	$className = str_replace(' ', '',ucfirst(str_replace('_', ' ',$params['filename'])));
		
	// Create presentation object
	if (class_exists($className,false)){
		$obj = new $className();		
	}else {
		$className.='Controller';
		$obj = new $className();
	}
	
	/* $arr=get_declared_classes();	
	if(in_array($className, $arr)){
		//echo 'yes';
		$obj = new $className();
	}else {
		//echo 'no';
		$className.='Controller';
		$obj = new $className();
	} */
	
	if (method_exists($obj, 'init'))
	{
		$obj->init();
	}

	// Assign template variable
	$smarty->assign($params['assign'], $obj);

}
?>
