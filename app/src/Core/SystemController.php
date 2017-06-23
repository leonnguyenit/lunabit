<?php

namespace Luna\Core;

use Interop\Container\ContainerInterface;

/**
 * System Base Controller
 *
 * @author leonnguyenit
 */
abstract class SystemController extends BaseController
{

    /**
     * System controller constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);

    }
}
