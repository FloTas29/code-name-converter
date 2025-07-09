<?php

namespace Cordon\CodeNameConverterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_device")
 */
class MarketDevice
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id = null;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"public"})
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"public"})
     */
    private $techModel;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"public"})
     */
    private $marketingModel;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     * @return $this
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTechModel()
    {
        return $this->techModel;
    }

    /**
     * @param string $techModel
     * @return $this
     */
    public function setTechModel($techModel)
    {
        $this->techModel = $techModel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMarketingModel()
    {
        return $this->marketingModel;
    }

    /**
     * @param string $marketingModel
     * @return $this
     */
    public function setMarketingModel($marketingModel)
    {
        $this->marketingModel = $marketingModel;
        return $this;
    }
}