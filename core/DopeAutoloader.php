<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * Describes an autoloader.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
interface DopeAutoloader {

    /**
     * This method is invoked each time a class is used which has not yet been defined.
     * It should never be invoked manually
     * @param $name class name
     */
    public function autoload($name);
}