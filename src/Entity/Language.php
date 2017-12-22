<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 * @ORM\Table(name="languages")
 */
class Language
{

    /**
     * Magic __toString method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): ? int
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Language
     */
    public function setName($name): ? Language
    {
        $this->name = $name;

        return $this;
    }
}
