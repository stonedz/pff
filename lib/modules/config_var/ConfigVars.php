<?php

namespace pff\modules;

/**
 * Created by JetBrains PhpStorm.
 * User: alessandro
 * Date: 05/10/12
 * Time: 11.39
 * To change this template use File | Settings | File Templates.
 */
class ConfigVars extends \pff\AModule {

    private $entity;

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }


    public function getValue($var){

        $temp = $this->entity->getRepository('pff\models\ConfigVar')->findOneBy(array('var' => $var));
        return $temp->getValue();

    }

    public function setValue($var,$value){
        $temp = $this->entity->getRepository('pff\models\ConfigVar')->findOneBy(array('var' => $var));
        $temp->modValue($value);
        $this->entity->flush();
    }

}
