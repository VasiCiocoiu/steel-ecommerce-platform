<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Entity\Delivery;
use App\Entity\Provider;
use App\Entity\Warehouse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddressController extends AbstractController
{
    //Route to create a new address for a given id (user, provider, delivery, warehouse)
    #[Route('/add/address', name: 'address_create', methods: ['POST'])]
    public function createAddress(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $keys = array_keys($data);
        $lastArgument = end($keys);

        $address = new Address();
        $address->setStreet($data['street']);
        $address->setPostalCode($data['postalCode']);
        $address->setCity($data['city']);

        if ($lastArgument === 'userId') {
            $userId = $lastArgument;
            $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            if (!$user) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setUser($user);
        } elseif ($lastArgument === 'providerId') {
            $providerId = $lastArgument;
            $provider = $this->getDoctrine()->getRepository(Provider::class)->find($providerId);
            if (!$provider) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setProvider($provider);
        } elseif ($lastArgument === 'deliveryId') {
            $deliveryId = $lastArgument;
            $delivery = $this->getDoctrine()->getRepository(Delivery::class)->find($deliveryId);
            if (!$delivery) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setDelivery($delivery);
        } elseif ($lastArgument === 'warehouseId') {
            $warehouseId = $lastArgument;
            $warehouse = $this->getDoctrine()->getRepository(Warehouse::class)->find($warehouseId);
            if (!$warehouse) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setDelivery($warehouse);
        } else {
            return $this->json(['response' => 'Invalid request']);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($address);
        $entityManager->flush();

        return $this->json(['response' => 'ok']);
    }
    // Route to show the details of an address for a given id (user, provider, delivery, warehouse)
    #[Route('/get/address/type/{type}/id/{userId}', name: 'address_show', methods: ['GET'])]
    public function showAddress(string $type, int $userId): JsonResponse
    {
        if ($type == 'user') {
            $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            if (!$user) {
                return $this->json(['response' => 'Not found']);
            }
            $address = $user->getAddress();
        } elseif ($type == 'provider') {
            $provider = $this->getDoctrine()->getRepository(Provider::class)->find($userId);
            if (!$provider) {
                return $this->json(['response' => 'Not found']);
            }
            $address = $provider->getAddress();
        } elseif ($type == 'delivery') {
            $delivery = $this->getDoctrine()->getRepository(Delivery::class)->find($userId);
            if (!$delivery) {
                return $this->json(['response' => 'Not found']);
            }
            $address = $delivery->getAddress();
        } elseif ($type == 'warehouse') {

            $warehouse = $this->getDoctrine()->getRepository(Warehouse::class)->find($userId);
            if (!$warehouse) {
                return $this->json(['response' => 'Not found']);
            }
            $address = $warehouse->getAddress();
        } else {
            return $this->json(['response' => 'Invalid request']);
        }
        return $this->json([
            'id' => $address->getId(),
            'street' => $address->getStreet(),
            'postalCode' => $address->getPostalCode(),
            'city' => $address->getCity(),
        ]);
    }
    // Route to update the address for a given id (user, provider, delivery, warehouse)
    #[Route('/update/address', name: 'address_update', methods: ['PUT'])]
    public function updateAddress(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $keys = array_keys($data);
        $lastArgument = end($keys);

        $entityManager = $this->getDoctrine()->getManager();
        $address = $entityManager->getRepository(Address::class)->find($data['id']);

        if (!$address) {
            return $this->json(['response' => 'Not found']);
        }

        $address->setStreet($data['street']);
        $address->setPostalCode($data['postalCode']);
        $address->setCity($data['city']);

        if ($lastArgument === 'userId') {
            $userId = $lastArgument;
            $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            if (!$user) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setUser($user);
        } elseif ($lastArgument === 'providerId') {
            $providerId = $lastArgument;
            $provider = $this->getDoctrine()->getRepository(Provider::class)->find($providerId);
            if (!$provider) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setProvider($provider);
        } elseif ($lastArgument === 'deliveryId') {
            $deliveryId = $lastArgument;
            $delivery = $this->getDoctrine()->getRepository(Delivery::class)->find($deliveryId);
            if (!$delivery) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setDelivery($delivery);
        } elseif ($lastArgument === 'warehouseId') {
            $warehouseId = $lastArgument;
            $warehouse = $this->getDoctrine()->getRepository(Warehouse::class)->find($warehouseId);
            if (!$warehouse) {
                return $this->json(['response' => 'Not found']);
            }
            $address->setDelivery($warehouse);
        } else {
            return $this->json(['response' => 'Invalid request']);
        }
        $entityManager->flush();

        return $this->json(['response' => 'ok']);
    }
}
