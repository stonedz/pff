<?php

namespace pff\models;

/**
 * @Entity
 * @Table(name="xxx_image_testi")
 */
class XXXImageTesti extends \pff\AModel {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="text")
     */
    private $didascalia;

    /**
     * @Column(type="text")
     */
    private $note;

    /**
     * @Column(length=2)
     */
    private $lang;

    /**
     * @ManyToOne(targetEntity="XXXImage", inversedBy="testi")
     * @JoinColumn(name="idXXXImage", referencedColumnName="id")
     *
     */
    private $xxx;

    public function setDidascalia($didascalia)
    {
        $this->didascalia = $didascalia;
    }

    public function getDidascalia()
    {
        return $this->didascalia;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setXXX($xxx)
    {
        $this->xxx = $xxx;
    }

    public function getXXX()
    {
        return $this->xxx;
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
