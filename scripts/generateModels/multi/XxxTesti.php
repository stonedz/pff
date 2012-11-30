<?php

namespace pff\models;

/**
 * @Entity
 * @Table(name="xxx_testi")
 */
class XXXTesti extends \pff\AModel {

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
     * @Column(length=2)
     */
    private $lang;

    /**
     * @ManyToOne(targetEntity="XXX", inversedBy="testi")
     * @JoinColumn(name="idXXX", referencedColumnName="id")
     *
     */
    private $xxx;

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

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
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

    public function setTestoBreve($testo_breve)
    {
        $this->testo_breve = $testo_breve;
    }

    public function getTestoBreve()
    {
        return $this->testo_breve;
    }

    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    public function getTitolo()
    {
        return $this->titolo;
    }

 }
