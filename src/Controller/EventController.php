<?php

namespace App\Controller;

use App\Form\EventFileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="list_events")
     */
    public function index()
    {
        return $this->render(
            'event/index.html.twig'
        );
    }

    /**
     * @param Request $request
     * @Route("/upload", name="upload_events")
     *
     * @return Response
     */
    public function uploadEventFileAction(Request $request)
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
            $file     = $form->get('eventsFile')
                ->getData();
            $jsonData = file_get_contents($file);
            $jsonData = json_decode($jsonData, true);
            dump($jsonData);
            die;
        }

        return $this->render(
            'event/upload.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

}
