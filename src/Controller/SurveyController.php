<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Form\SurveyType;
use App\Repository\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/surveys')]
class SurveyController extends AbstractController
{
    #[Route('', name: 'survey_index', methods: ['GET'])]
    public function index(SurveyRepository $surveyRepository): Response
    {
        return $this->render('survey/index.html.twig', [
            'surveys' => $surveyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'survey_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $survey = new Survey();
        $form = $this->createForm(SurveyType::class, $survey);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $survey->setCreatedAt(new \DateTimeImmutable());

            $em->persist($survey);
            $em->flush();

            $this->addFlash('success', 'Survey created.');

            return $this->redirectToRoute('survey_index');
        }

        return $this->render('survey/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'survey_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Survey $survey, EntityManagerInterface $em): Response
    {
        if ($survey->getDeletedAt()) {
            throw $this->createNotFoundException('Survey not found.');
        }

        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Survey updated.');

            return $this->redirectToRoute('survey_index');
        }

        return $this->render('survey/edit.html.twig', [
            'form' => $form,
            'survey' => $survey,
        ]);
    }

    #[Route('/{id}', name: 'survey_delete', methods: ['POST'])]
    public function delete(Request $request, Survey $survey, EntityManagerInterface $em): Response
    {
        if ($survey->getDeletedAt()) {
            throw $this->createNotFoundException('Survey not found.');
        }

        if ($this->isCsrfTokenValid('delete'.$survey->getId(), $request->request->get('_token'))) {
            $survey->setDeletedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'Survey deleted.');
        }

        return $this->redirectToRoute('survey_index');
    }
}
