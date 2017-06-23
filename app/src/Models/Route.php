<?php

namespace Luna\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Route Model
 * Table: routes
 * @author leonnguyenit
 */
class Route extends Model
{
	public $timestamps = false;

	/**
	 * Get list of routes
	 * @param  string $type Route type: admin, site, system, rests
	 * @return array
	 */
	public static function getRoutes($type = null)
	{
		if (isset($type)) {
			return Route::orderBy('controller')->where('type', $type)->get()->toArray();
		}
		return Route::orderBy('type')->orderBy('controller')->get()->toArray();
	}

	/**
	 * Get admin routes
	 * @return array
	 */
	public static function adminRoutes()
	{
		return Route::getRoutes('admin');
	}

	/**
	 * Get route info by id
	 * @param  integer $id
	 * @return array
	 */
	public static function getById($id = null)
	{
		return Route::where('id', $id)->first();
	}

	/**
	 * Write cache file all routes
	 */
	public function cacheFile()
	{
		$data[] = "<?php";
		$data[] = "defined('LUNA_SYSTEM') or die('Hacking attempt!');\n";

		$routes = Route::orderBy('type')->orderBy('controller')->get()->toArray();

		if (!empty($routes)) {
			foreach ($routes as $route) {
				$call_back = isset($route['action']) ? $route['controller'] . ":" . $route['action'] : $route['controller'];
				if (!isset($route['method'])) {
					$data[] = '$app->get("' . $route['route'] . '", "' . $call_back . '");';
				} else {
					$methods = explode(',', preg_replace('/\s+/', '', $route['method']));
					foreach ($methods as $method) {
						$data[] = '$app->' . strtolower($method) . '("' . $route['route'] . '", "' . $call_back . '");';
					}
				}
			}
		}

		$output = implode("\n", $data);

		write_file(LUNA_CACHEPATH . "/data/routes.php", $output);
	}
}
