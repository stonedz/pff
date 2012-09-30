<?php

class Test_Controller extends \pff\AController
{


    public function index()
    {
        //$tmp = new \pff\models\Test();
        /**
         * @var \pff\modules\Cookies
         */
        $cookieM = $this->_moduleManager->loadModule('cookies');
        //$cookieM->setCookie('prova', 'unonono',1);
        if ($p = $cookieM->getCookie('prova')) {
            echo $p;
            $cookieM->deleteCookie('prova');
        }

        /**
         * @var \pff\AModel
         */
        //$tmp = $this->_em->find("\\pff\\models\\Test", 1);
        //$this->_view = \pff\FView::create('test_View.php', 'PHP');

        $tmp = $this->_em->getRepository('pff\models\Test')->findOneBy(array('username' => 'paolo'));
        if ($tmp == false) {

            /** @var $logger \pff\modules\Logger */
            $logger = $this->_moduleManager->getModule('logger');
            $logger->log('Prova di un messaggio', 1);

            $logger1 = new \pff\modules\Logger();
            $logger1->log('Seconda prova');
            die();
        }

        $tmp->setApp($this->_app);
        $one = \pff\FView::create('test_View.php', $this->_app);
        $one->set('titolo', 'Pagina di prova');
        $one->set('nome', $tmp->getName());
        $this->addView($one);

        /*$two = \pff\FView::create('test_View.php', $this->_app);
        $two->set('titolo', 'Pagina di prova');
        $two->set('nome', $tmp->getName());
        $this->addView($two);*/

        //$this->_view->render();

        /*$tmp1 = new \pff\models\Test();
        $tmp1->setName("Piolo terzo");
        $tmp1->setColor("giallo");
        $addr = new \pff\models\Address();
        $addr->setStreet("via del Vicodsds");
        $this->_em->persist($addr);
        $tmp1->setAddress($addr);
        $this->_em->persist($tmp1);
        $this->_em->flush();*/

        $config = new \Doctrine\DBAL\Configuration();
//..
        $connectionParams = $this->_config->getConfigData('databaseConfigDev');
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        $sql = "SELECT * FROM `users`";
        $stmt = $conn->query($sql); // Simple, but has several drawbacks

        while ($row = $stmt->fetch()) {
            echo $row['name'];
        }

        // print_r($tmp);
    }

    public function anAction()
    {
        throw new \pff\ModuleException("Questa è una prova");
        $two = \pff\FView::create('test_View.php', $this->_app);
        $two->set('titolo', 'Pagina di prova');
        $two->set('nome', $this->_params[0]);
        $this->addView($two);

    }

    public function testUno()
    {
        $username = 'paolo';
        $pass = 'paolo';
        $auth = new \pff\modules\Auth();
        $auth->login($username, $pass, $this->_em);
        $auth->checkAuth();
        $auth->logout();
        print_r($_SESSION);
    }

}