<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Tests\Fixtures;

use A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class ProductTranslation implements OneLocaleInterface
{
    use Translation;

    /**
     * @ORM\Column(name="title", nullable=true)
     */
    private string $title;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\Length(min="3")
     */
    private ?string $description;

    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}