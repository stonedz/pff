<?php

class Test_Controller extends \pff\AController {


    public function index(){
        //$tmp = new \pff\models\Test();
        $tmp = $this->_em->find("\\pff\\models\\Test", 1);
        //$this->_view = \pff\FView::create('test_View.php', 'PHP');
        $one = \pff\FView::create('test_View.tpl', 'smarty');
        $one->set('titolo', 'Pagina di prova');
        $one->set('nome', $tmp->getName());
        $this->addView($one);

        $two = \pff\FView::create('test_View.php');
        $two->set('titolo', 'Pagina di prova');
        $two->set('nome', $tmp->getName());
        $this->addView($two);

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

    public function anAction() {
        $two = \pff\FView::create('test_View.php');
        $two->set('titolo', 'Pagina di prova');
        $two->set('nome', 'Sono anAction');
        $this->addView($two);

    }
}