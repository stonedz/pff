<?php

namespace pff\models;

/**
 * @Entity
 * @Table(name="xxx_comment")
 */
class XXXComm extends \pff\AModel {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="text")
     */
    private $commento;

    /**
     * @Column(type="date")
     */
    private $data;

    /**
     * @Column(type="text")
     */
    private $note;

     /**
     * @ManyToOne(targetEntity="XXX", inversedBy="comments")
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

    public function setCommento($commento)
    {
        $this->commento = $commento;
    }

    public function getCommento()
    {
        return $this->commento;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }



}

