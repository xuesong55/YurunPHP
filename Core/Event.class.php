<?php
/**
 * 事件类
 * @author Yurun <admin@yurunsoft.com>
 */
class Event
{
	// 事件绑定记录
	private static $events;

	// 引用参数数量
	private static $args_num=5;
	/**
	 * 初始化
	 */
	public static function init()
	{
		self::$events = array ();
		// 获取插件列表
		$data = Config::get('Plugin');
		// 加载插件
		foreach ($data as $value)
		{
			include_once APP_PLUGIN . "{$value}/{$value}.php";
		}
		return true;
	}
	
	/**
	 * 注册事件
	 *
	 * @param string $event        	
	 * @param mixed $callback        	
	 */
	public static function register($event, $callback)
	{
		if (! isset(self::$events[$event]))
		{
			self::$events[$event] = array ();
		}
		self::$events[$event][] = $callback;
	}
	
	/**
	 * 触发事件(监听事件)
	 *
	 * @param name $event        	
	 * @param boolean $once        	
	 * @return mixed
	 */
	public static function trigger($event, &$params=array())
	{
		if (isset(self::$events[$event]))
		{
			foreach (self::$events[$event] as $item)
			{
				if(call_user_func_array($item,arrayRefer($params))===true)
				{
					return true;
				}
			}
			return false;
		}
		return true;
	}
}