<?php

namespace pff\models;

/**
 * @Entity
 * @Table(name="xxx_image")
 */
class XXXImage extends \pff\AModel {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="text")
     */
    private $foto;

    /**
     * @Column(type="integer",options={"default"=0})
     */
    private $ordine;

    /**
     * @OneToMany(targetEntity="XXXImageTesti", mappedBy="xxx")
     */
    private $testi;

    /**
     * @ManyToOne(targetEntity="XXX", inversedBy="images")
     * @JoinColumn(name="idXXX", referencedColumnName="id")
     *
     */
    private $xxx;

    public function __construct() {

        $this->testi = new ArrayCollection();
    }

    public function setTesti($testi)
    {
        $this->testi = $testi;
    }

    public function getTesti()
    {
        return $this->testi;
    }


    public function getTestiTradotti($l,$ld)
    {
        foreach ($this->testi as $t){

            if ($t->getLang() == $l){
                $lang = $t;
            }
            if ($t->getLang() == $ld){
                $lang2 = $t;
            }
        }

        $result = array();

        /**
         * Controllo valore della lingua scelta altrimenti lingua default altrimenti vuoto
         *
         */

        if (isset($lang) && strlen($lang->getDidascalia()) > 0 ){
            $result['didascalia'] = $lang->getDidascalia();
        } elseif (isset($lang2) && strlen($lang2->getDidascalia()) > 0 ) {
            $result['didascalia'] = $lang2->getDidascalia();
        } else {
            $result['didascalia'] = "";
        }

        if (isset($lang) && strlen($lang->getNote()) > 0 ){
            $result['note'] = $lang->getNote();
        } elseif (isset($lang2) && strlen($lang2->getNote()) > 0 ) {
            $result['note'] = $lang2->getNote();
        } else {
            $result['note'] = "";
        }

        return $result;
    }

    public function setOrdine($ordine)
    {
        $this->ordine = $ordine;
    }

    public function getOrdine()
    {
        return $this->ordine;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setXXX($xxx)
    {
        $this->xxx = $xxx;
    }

    public function getXXX()
    {
        return $this->xxx;
    }

}

