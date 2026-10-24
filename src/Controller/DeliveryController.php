<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Bill;
use App\Entity\User;
use App\Entity\Delivery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeliveryController extends AbstractController
{
    // Route to create a new Delivery object from a JSON 
    #[Route('/add/delivery/', methods: ['POST'])]
    public function createDelivery(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $delivery = new Delivery();
        $delivery->setDeliveryStatus($data['deliveryStatus']);
        $delivery->setDeliveryPrice($data['deliveryPrice']);

        $address = $this->getDoctrine()->getRepository(Address::class)->find($data['addressId']);
        $delivery->addAddress($address);

        $bill = $this->getDoctrine()->getRepository(Bill::class)->find($data['billId']);
        $delivery->setBill($bill);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($delivery);
        $entityManager->flush();

        return $this->json(['id' => $delivery->getId()]);
    }

    // Route to get a Delivery object by ID
    #[Route('/get/delivery/{id}', methods: ['GET'])]
    public function getDelivery(int $id): JsonResponse
    {
        $delivery = $this->getDoctrine()->getRepository(Delivery::class)->find($id);

        if (!$delivery) {
            return $this->json(['response' => 'Not Found']);
        }

        return $this->json($delivery);
    }

    // Route to get all the deliveries for a given User ID for a given status
    #[Route('/get/deliveries/user/{userId}/status/{status}', methods: ['GET'])]
    public function getDeliveries(int $userId, string $status): JsonResponse
    {
        $deliveries = $this->getDoctrine()->getRepository(Delivery::class)->findBy(['deliveryStatus' => $status]);
        // TO IMPROVE
        $filteredDeliveries = array_filter($deliveries, function ($delivery) use ($userId) {
            $bill = $delivery->getBill();
            $user = $bill->getUser();

            return $user->getId() === $userId;
        });

        return $this->json($filteredDeliveries);
    }

    // Route to update the delivery status for a given id
    #[Route('/update/delivery/{id}', methods: ['PUT'])]
    public function updateDelivery(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $delivery = $entityManager->getRepository(Delivery::class)->find($id);

        if (!$delivery) {
            return $this->json(['response' => 'Not Found']);
        }

        empty($data['deliveryStatus']) ? true : $delivery->setDeliveryStatus($data['deliveryStatus']);

        $entityManager->flush();

        return $this->json(['response' => 'Ok']);
    }
}
