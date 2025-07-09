<?php

namespace Cordon\CodeNameConverterBundle\Controller;

use Cordon\CodeNameConverterBundle\Entity\MarketDevice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MarketDeviceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param SerializerInterface $serializer
     * @param $techModel
     * @return Response
     * @Route("/market-device/{techModel}", name="get_market_device")
     */
    public function getMarketDevice(SerializerInterface $serializer, $techModel): Response
    {
        $repo = $this->entityManager->getRepository(MarketDevice::class);
        $marketDevice = $repo->findOneBy(['techModel' => $techModel]);

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
