<?php

namespace Cordon\CodeNameConverterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'market_device')]
class MarketDevice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"public"})
     */
    private string $manufacturer;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"public"})
     */
    private string $techModel;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups({"public"})
     */
    private string $marketingModel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getTechModel(): string
    {
        return $this->techModel;
    }

    public function setTechModel(string $techModel): self
    {
        $this->techModel = $techModel;
        return $this;
    }

    public function getMarketingModel(): string
    {
        return $this->marketingModel;
    }

    public function setMarketingModel(string $marketingModel): self
    {
        $this->marketingModel = $marketingModel;
        return $this;
    }
}
