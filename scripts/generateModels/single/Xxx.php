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
     * @Column(length=100)
     */
    private $titolo;

    /**
     * @Column(length=250)
     */
    private $testo_breve;

    /**
     * @Column(type="text")
     */
    private $testo;

    /**
     * @Column(type="text")
     */
    private $note;

    /**
     * @Column(type="date")
     */
    private $data;

    /**
     * @Column(length=100)
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


    public function __construct() {
        $this->images = new ArrayCollection();
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

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setTesto($testo)
    {
        $this->testo = $testo;
    }

    public function getTesto()
    {
        return $this->testo;
    }

    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    public function getTitolo()
    {
        return $this->titolo;
    }

    public function setTestoBreve($testo_breve)
    {
        $this->testo_breve = $testo_breve;
    }

    public function getTestoBreve()
    {
        return $this->testo_breve;
    }



    public function getFormattedXXX(){

        $result = array();

        $result["id"] = $this->getId();
        $result["titolo"] = $this->getTitolo();
        $result["testo_breve"] = $this->getTestoBreve();
        $result["testo"] = $this->getTesto();
        $result["note"] = $this->getNote();
        $result["data"] = $this->getData();
        $result["autore"] = $this->getAutore();
        $result['foto'] = array();


        foreach ($this->getImages() as $f){

            $temp=array();
            $temp['foto'] = $f->getFoto();
            $temp['didascalia'] = $f->getDidascalia();
            $result["foto"][] = $temp;

        }

       return $result;

    }
}
