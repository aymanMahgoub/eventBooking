<?php

namespace App\Controller;

use App\Form\EventFileType;
use App\Repository\EventDetailsRepository;
use App\Services\EventFileProcessorService;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="list_events")
     * @param Request                $request
     * @param EventDetailsRepository $eventDetailsRepository
     * @param PaginatorInterface     $paginator
     *
     * @return Response
     */
    public function index(
        Request $request,
        EventDetailsRepository $eventDetailsRepository,
        PaginatorInterface $paginator
    ) {
        $events = $eventDetailsRepository->findAll();

        $limit          = $request->query->get('limit', 5);
        $page           = $request->query->get('page', 1);
        $events     = $paginator->paginate(
            $events,
            $page,
            $limit
        );
        return $this->render(
            'event/index.html.twig',
            [
                'events' => $events,
            ]
        );
    }

    /**
     * @param Request                   $request
     * @param EventFileProcessorService $eventFileProcessorService
     *
     * @return Response
     * @Route("/upload", name="upload_events")
     *
     */
    public function uploadEventFileAction(Request $request, EventFileProcessorService $eventFileProcessorService)
    {
        $form = $this->createForm(
            EventFileType::class,
            null,
            [
                'action' => $this->generateUrl('upload_events'),
                'method' => 'POST',
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var File $file */
            $file       = $form->get('eventsFile')
                ->getData();
            $eventsData = file_get_contents($file);
            $eventsData = json_decode($eventsData, true);
            try {
                $eventFileProcessorService->processEventData($eventsData);
                $this->addFlash('success', 'Events added successfully');
                return $this->redirectToRoute('list_events');
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render(
            'event/upload.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

}
