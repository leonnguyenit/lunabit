<?php

namespace Luna\Controllers\Rests;

use Luna\Core\RequestInterface;
use Luna\Core\ResponseInterface;
use Luna\Core\RestsController;
use Psr\Http\Message\ServerRequestInterface;

class Intro extends RestsController
{

	/**
	 * Abstract Default Controller Action
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 */
	public function __invoke( $request, $response, $args ) {
		// TODO: Implement __invoke() method.
	}

	/**
	 * Get data (all or single)
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 *
	 * @return string JSON
	 */
	function get( $request, $response, $args ) {
		// TODO: Implement get() method.
		return $response->withJson(json_encode(['message' => $this->translator->trans('messages.system', ['app_name' => get_option('name')])]), 200);
	}

	/**
	 * Create new data
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 *
	 * @return string JSON
	 */
	function create( $request, $response, $args ) {
		// TODO: Implement create() method.
	}

	/**
	 * Update data
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 *
	 * @return string JSON
	 */
	function update( $request, $response, $args ) {
		// TODO: Implement update() method.
	}

	/**
	 * Delete data
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 *
	 * @return string JSON
	 */
	function delete( $request, $response, $args ) {
		// TODO: Implement delete() method.
}}