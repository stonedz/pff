<?php

namespace pff;

/**
 * Manages routig
 *
 * Date: 3/8/12
 *
 * @author paolo.fagni<at>gmail.com
 * @category
 * @version
 */
class Routing {

    /**
     * @var \SplObjectStorage Array of IRoutingStrategies
     */
    private $_routingStrategies;

    public function __construct() {
        $this->_routingStrategies = new \SplObjectStorage();
    }

    /**
     *
     *
     * @param array $request The exploded request
     */
    public function applyRouting($request){
        if($this->_routingStrategies->count() > 0) {
            $this->_routingStrategies->rewind();
            while($this->_routingStrategies->valid()){

                $this->_routingStrategies->next();
            }
        }
        else {
            throw new \pff\RoutingException('No routing strategy set.');
        }
    }

    /**
     * Register a new RoutingStrategy
     *
     * @param string $routingStrategyName
     */
    public function addRouting($routingStrategyName){
        $routingStrategyName = '\\pff\\'.$routingStrategyName;
        if(class_exists($routingStrategyName)){
            $this->_routingStrategies->attach(new $routingStrategyName);
        }
        else{
            throw new \pff\RoutingException('Invalid routing strategy: '.$routingStrategyName);
        }
    }

    /**
     * Returns current active routingStrategies
     *
     * @return \SplObjectStorage
     */
    public function getActiveRouting(){
        return $this->_routingStrategies;
    }
}
