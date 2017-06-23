<?php

namespace Luna\Core;

use Interop\Container\ContainerInterface;

/**
 * RestController
 *
 * REST API base controller
 *
 * @author leonnguyenit
 */
abstract class RestsController extends BaseController
{

	/**
	 * REST Controller Constructor
	 * @param ContainerInterface $ci
	 */
	public function __construct(ContainerInterface $ci)
	{
		parent::__construct($ci);
		$this->data['data'] = [];
		$this->status = 200;
		$this->messages = [
			'get_success' => 'Get data successfully.',
			'get_fail' => 'Fail! Can not get data.',
			'create_success' => 'Data has been added successfully!',
			'create_fail' => 'Fail! Data can not be add to system.',
			'update_success' => 'Data has been updated successfully!',
			'update_fail' => 'Fail! Data can not be update',
			'update_fail_not_exists' => 'Fail! Item not exists, can not be update.',
			'delete_success' => 'Data has been removed successfully!',
			'delete_fail' => 'Fail! Data can not be remove.',
		];
	}

	/**
	 * Get data (all or single)
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return string JSON
	 */
	abstract function get($request, $response, $args);

	/**
	 * Create new data
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return string JSON
	 */
	abstract function create($request, $response, $args);

	/**
	 * Update data
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return string JSON
	 */
	abstract function update($request, $response, $args);

	/**
	 * Delete data
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return string JSON
	 */
	abstract function delete($request, $response, $args);
}
