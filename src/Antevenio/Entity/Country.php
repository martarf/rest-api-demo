<?php

namespace Antevenio\Entity;

/**
* Antevenio\Entity\Country
*
* @Table(name="country")
* @Entity(repositoryClass="Antevenio\Entity\CountryRepository")
*/
class Country {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /** @Column(type="text") */

    /**
     * @var string $name
     * @Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string $code
     * @Column(type="string", length=3)
     */
    private $code;


    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
