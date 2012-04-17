<?php

class Test_Controller extends \pff\AController {


    public function index(){
        //$tmp = new \pff\models\Test();
        $tmp = $this->_em->find('\\pff\\models\\Test', 1);
        $this->_view = \pff\FView::create('test_View.php', 'PHP');
        $this->_view->set('titolo', 'Pagina di prova');
        $this->_view->set('nome', $tmp->getName());

        //$this->_view->render();
        /*$tmp1 = new \pff\models\Test();
        $tmp1->setName("Piolo secondo");
        $addr = new \pff\models\Address();
        $addr->setStreet("via del Vico");
        $this->_em->persist($addr);
        $tmp1->setAddress($addr);
        $this->_em->persist($tmp1);
        $this->_em->flush();*/



       // print_r($tmp);
    }

}