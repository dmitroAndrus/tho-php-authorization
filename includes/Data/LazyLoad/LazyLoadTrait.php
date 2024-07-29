<?php

/**
 * This file contains LazyLoadTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\LazyLoad;

/**
 * LazyLoadTrait is a trait, it contains methods to load property data only when required.
 *
 * Can be used to load data from some source (i.e. database) on request.
 */
trait LazyLoadTrait
{
    /**
     * Lazy load data.
     *
     * @var Callable[]
     */
    protected $lazyLoad = [];

    /**
     * Add lazy load.
     *
     * Add callable to get specified property data.
     *
     * @param string $name Callable/property name.
     * @param callable $callable Callable to get property data.
     *
     * @return boolean Callable added or not.
     */
    protected function addLazyLoad($name, $callable)
    {
        if (is_callable($callable)) {
            $this->lazyLoad[$name] = $callable;
            return true;
        }
        return false;
    }

    /**
     * Has lazy load.
     *
     * @param string $name Callable/property name.
     *
     * @return self
     */
    protected function hasLazyLoad($name)
    {
        return isset($this->lazyLoad[$name]);
    }

    /**
     * Remove lazy load.
     *
     * Remove callable by name, if there is one.
     *
     * @param string $name Callable/property name.
     *
     * @return self
     */
    protected function removeLazyLoad($name)
    {
        if (isset($this->lazyLoad[$name])) {
            unset($this->lazyLoad[$name]);
        }
        return $this;
    }

    /**
     * Remove all lazy load callables.
     *
     * @return self
     */
    protected function cleanupLazyLoad()
    {
        $this->lazyLoad = [];
        return $this;
    }

    /**
     * Load property data.
     *
     * Runs callable by name, if there is one.
     *
     * @param string $name Callable/property name.
     *
     * @return mixed Loaded data.
     */
    protected function runLazyLoad($name)
    {
        if (isset($this->lazyLoad[$name])) {
            // Get property data.
            $data = call_user_func($this->lazyLoad[$name], $this);
            // Remove lazy load after getting data.
            $this->removeLazyLoad($name);
            return $data;
        }
        return null;
    }
}
