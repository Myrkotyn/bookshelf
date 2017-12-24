<?php

namespace App\Form\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

class Book
{
    /**
     * @Assert\NotBlank()
     */
    private $title;

    private $imageName;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="book_image", fileNameProperty="imageName")
     * @Assert\File(maxSize="2M", mimeTypesMessage = "Please upload a valid image")
     */
    private $imageFile;

    /**
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $publicationDate;

    /**
     * @Assert\NotBlank()
     */
    private $ISBNNumber;

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): ? string
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title): ? Book
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get image name
     *
     * @return string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Set image name
     *
     * @param string $imageName
     * @return Book
     */
    public function setImageName($imageName): ? Book
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getImageFile(): ? File
    {
        return $this->imageFile;
    }

    /**
     * Set file
     *
     * @param File|UploadedFile $imageFile
     * @return Book
     */
    public function setImageFile(File $imageFile): ? Book
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Get publication date
     *
     * @return \DateTime
     */
    public function getPublicationDate(): ? \DateTime
    {
        return $this->publicationDate;
    }

    /**
     * Set publication date
     *
     * @param \DateTime $publicationDate
     * @return Book
     */
    public function setPublicationDate(\DateTime $publicationDate): ? Book
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get ISBN number
     *
     * @return string
     */
    public function getISBNNumber()
    {
        return $this->ISBNNumber;
    }

    /**
     * Set ISBN number
     *
     * @param string $ISBNNumber
     * @return Book
     */
    public function setISBNNumber($ISBNNumber): ? Book
    {
        $this->ISBNNumber = $ISBNNumber;

        return $this;
    }
}