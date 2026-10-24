<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\Regex;
use App\Document\Analytics;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AnalyticsController extends AbstractController
{
    // Route to create a new entry
    #[Route('/create_entry', name: 'app_access', methods: 'POST')]
    public function new(Request $request, DocumentManager $dm): Response
    {

        $data = json_decode($request->getContent(), true);

        $access = new Analytics();

        $access->setUserIpAddress($data['userIpAddress']);
        $access->setAccessDate($data['accessDate']);
        $access->setAccessTime($data['accessTime']);
        $access->setStatus($data['status']);
        $access->setUrl($data['url']);
        $access->setUserAgent($data['userAgent']);

        $dm->persist($access);
        $dm->flush();
        return new Response('id', Response::HTTP_OK);
    }
    // Route to show the details of a specific entry based on Id
    #[Route(path: '/get/analytics/{id}', name: 'access_show', methods: 'GET')]

    public function show(string $id, DocumentManager $dm): Response
    {
        $access = $dm->getRepository(Analytics::class)->find($id);

        if (!$access) {
            throw $this->createNotFoundException('No access found for id ' . $id);
        }
        return $this->json($access);
    }

    // Route to list all the URLs and count the number of times each URL has been accessed
    #[Route(path: '/listUrlAndCount', name: 'access_list_url_count', methods: 'GET')]
    public function listUrlAndCount(DocumentManager $dm): Response
    {
        $accessList = $dm->getRepository(Analytics::class)->findAll();
        $urlCountMap = [];

        foreach ($accessList as $access) {
            $url = $access->getUrl();

            if (!isset($urlCountMap[$url])) {
                $urlCountMap[$url] = 0;
            }

            $urlCountMap[$url]++;
        }

        return $this->json($urlCountMap);
    }
    // Route to count all the entries with $status 404
    #[Route(path: '/count404', name: 'access_list_404', methods: 'GET')]
    public function count404(DocumentManager $dm): Response
    {
        $accessList = $dm->getRepository(Analytics::class)->findBy(['status' => '404']);
        return $this->json(count($accessList));
    }
    // Route to list all the ID of the entries for a given URL
    #[Route(path: '/listIpForUrl/{url}', name: 'access_list_url_access', methods: 'GET')]
    public function listUrlAccess(string $url, DocumentManager $dm): Response
    {
        $accessList = $dm->getRepository(Analytics::class)->findBy(['url' => "/$url"]);
        $urlAccessList = array_map(fn($access) => $access->getId(), $accessList);
        return $this->json($urlAccessList);
    }

    // Route to delete an entry based on ID
    #[Route(path: '/delete/analytics/{id}', name: 'access_delete', methods: 'DELETE')]
    public function delete(string $id, DocumentManager $dm): Response
    {
        $access = $dm->getRepository(Analytics::class)->find($id);

        if (!$access) {
            throw $this->createNotFoundException('No access found for id ' . $id);
        }

        $dm->remove($access);
        $dm->flush();

        return new Response('Access deleted successfully', Response::HTTP_OK);
    }

    // Route to list all the entries with a specific status
    #[Route(path: '/listByStatus/{status}', name: 'access_list_by_status', methods: 'GET')]
    public function listByStatus(string $status, DocumentManager $dm): Response
    {
        $accessList = $dm->getRepository(Analytics::class)->findBy(['status' => $status]);
        return $this->json($accessList);
    }
    // Route to count the number of entries for a specific hour
    #[Route(path: '/countHour/{hour}', name: 'analytics_count_hour', methods: 'GET')]
    public function countHour(string $hour, DocumentManager $dm): Response
    {
        $accessList = $dm->getRepository(Analytics::class)->createQueryBuilder()
            ->field('accessTime')->equals(new \MongoDB\BSON\Regex("^$hour:", "i"))
            ->getQuery()
            ->execute();

        $hourCount = count($accessList);
        return $this->json($hourCount);
    }
    // Route to count the number of entries for a specific date
    #[Route(path: '/countDate/{day}-{month}-{year}', name: 'analytics_count_date', methods: 'GET')]
    public function countDate(string $day, string $month, string $year, DocumentManager $dm): Response
    {
        $accessList = $dm->getRepository(Analytics::class)->createQueryBuilder()
            ->field('accessDate')->equals(new \MongoDB\BSON\Regex("^$day-$month-$year", "i"))
            ->getQuery()
            ->execute();

        $dateCount = count($accessList);
        return $this->json($dateCount);
    }
}
