<?php

namespace Cordon\CodeNameConverterBundle\Controller;

use Cordon\CodeNameConverterBundle\Entity\MarketDevice;
use Cordon\CodeNameConverterBundle\Interfaces\MarketNameProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MarketDeviceController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MarketNameProvider $provider)
    {
        $this->entityManager = $entityManager;
        $this->provider = $provider;
    }

    /**
     * @param SerializerInterface $serializer
     * @param $techModel
     * @return Response
     * @Route("/market-device/{techModel}", name="get_market_device")
     */
    public function getMarketDevice(SerializerInterface $serializer, $techModel)
    {
        $marketDevice = $this->provider->getMarketName("apple", $techModel);

        if (is_null($marketDevice)) {
            $repo = $this->entityManager->getRepository(MarketDevice::class);
            $marketDevice = $repo->findOneBy(['techModel' => $techModel]);
        }

        if (!is_null($marketDevice)) {
            $json = $serializer->serialize($marketDevice, 'json', [
                'groups' => ['public']
            ]);

            return new JsonResponse($json, 200, [], true);
        } else {
            return new Response(json_encode(['error' => 'No MarketDevice Found']), Response::HTTP_NOT_FOUND);
        }
    }
}
