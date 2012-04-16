<?php

namespace pff;



/**
 * Model that will use ORM to obtain object persistance
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AModelORM extends \pff\AModel {

    /**
     * @var \doctrine\ORM\EntityManager
     */
    protected $_em;

    public function __construct() {

    }

}
