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
     * @Column(length=100)
     */
    private $foto;

    /**
     * @Column(type="text")
     */
    private $didascalia;

    /**
     * @Column(type="text")
     */
    private $note;

    /**
     * @Column(type="integer",options={"default"=0})
     */
    private $ordine;

    /**
     * @ManyToOne(targetEntity="XXX", inversedBy="images")
     * @JoinColumn(name="idXXX", referencedColumnName="id")
     *
     */
    private $xxx;


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

    public function setDidascalia($didascalia)
    {
        $this->didascalia = $didascalia;
    }

    public function getDidascalia()
    {
        return $this->didascalia;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNote()
    {
        return $this->note;
    }



}

