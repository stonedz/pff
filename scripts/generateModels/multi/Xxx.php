<?php

namespace pff\models;

/**
 * @Entity
 * @Table(name="xxx")
 */
class XXX extends \pff\AModel {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="date")
     */
    private $data;

    /**
     * @Column(type="text")
     */
    private $copertina;

   /**
     * @Column(length=100)
     */
    private $autore;

    /**
     * @Column(type="boolean",options={"default"=1})
     */
    private $attivo = 1;

    /**
     * @OneToMany(targetEntity="XXXImage", mappedBy="xxx")
     * @OrderBy({"ordine" = "DESC"})
     */
    private $images;

    /**
     * @OneToMany(targetEntity="XXXTesti", mappedBy="xxx")
     */
    private $testi;


    public function __construct() {
        $this->images = new ArrayCollection();
        $this->testi = new ArrayCollection();
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function setCopertina($copertina)
    {
        $this->copertina = $copertina;
    }

    public function getCopertina()
    {
        return $this->copertina;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setAttivo($attivo)
    {
        $this->attivo = $attivo;
    }

    public function getAttivo()
    {
        return $this->attivo;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setAutore($autore)
    {
        $this->autore = $autore;
    }

    public function getAutore()
    {
        return $this->autore;
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

        if (isset($lang) && strlen($lang->getTitolo()) > 0 ){
             $result['titolo'] = $lang->getTitolo();
         } elseif (isset($lang2) && strlen($lang2->getTitolo()) > 0 ) {
             $result['titolo'] = $lang2->getTitolo();
         } else {
             $result['titolo'] = "";
         }

        if (isset($lang) && strlen($lang->getTestoBreve()) > 0 ){
            $result['testo_breve'] = $lang->getTestoBreve();
        } elseif (isset($lang2) && strlen($lang2->getTestoBreve()) > 0 ) {
            $result['testo_breve'] = $lang2->getTesto_breve();
        } else {
            $result['testo_breve'] = "";
        }

        if (isset($lang) && strlen($lang->getTesto()) > 0 ){
            $result['testo'] = $lang->getTesto();
        } elseif (isset($lang2) && strlen($lang2->getTesto()) > 0 ) {
            $result['testo'] = $lang2->getTesto();
        } else {
            $result['testo'] = "";
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



    public function getFormattedXXX($lang = 'it'){

        $lang_default = $this->_app->getConfig()->getConfigData('default_language');

        $result = array();

        $result["id"] = $this->getId();
        $result["data"] = $this->getData();
        $result["autore"] = $this->getAutore();
        $result['foto'] = array();

        foreach ($this->getImages() as $f){

            $temp=array();
            $temp['foto'] = $f->getFoto();
            $temp['didascalia'] = $f->getTestiTradotti($lang,$lang_default);
            $result["foto"][] = $temp;

        }

       $tt = $this->getTestiTradotti($lang,$lang_default);

        $result["titolo"] = $tt['titolo'];
        $result["testo_breve"] = $tt['testo_breve'];
        $result["testo"] = $tt['testo'];
        $result["note"] = $tt['note'];


        return $result;

    }
}
