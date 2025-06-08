<?php

namespace App\Controller;

use App\Entity\Panelist;
use App\Form\AssignSurveysType;
use App\Form\PanelistType;
use App\Repository\PanelistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panelists')]
class PanelistController extends AbstractController
{
    #[Route('', name: 'panelist_index', methods: ['GET'])]
    public function index(PanelistRepository $panelistRepository): Response
    {
        return $this->render('panelist/index.html.twig', [
            'panelists' => $panelistRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'panelist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $panelist = new Panelist();
        $form = $this->createForm(PanelistType::class, $panelist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($panelist);
            $em->flush();

            $this->addFlash('success', 'Panelist created successfully.');

            return $this->redirectToRoute('panelist_index');
        }

        return $this->render('panelist/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'panelist_show', methods: ['GET'])]
    public function show(Panelist $panelist): Response
    {
        $form = $this->createForm(AssignSurveysType::class, $panelist);

        return $this->render('panelist/show.html.twig', [
            'panelist' => $panelist,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'panelist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panelist $panelist, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PanelistType::class, $panelist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Panelist updated.');

            return $this->redirectToRoute('panelist_index');
        }

        return $this->render('panelist/edit.html.twig', [
            'form' => $form,
            'panelist' => $panelist,
        ]);
    }

    #[Route('/{id}/assign-surveys', name: 'panelist_assign_surveys', methods: ['POST'])]
    public function assignSurveys(
        Request $request,
        Panelist $panelist,
        EntityManagerInterface $em,
    ): Response {
        $form = $this->createForm(AssignSurveysType::class, $panelist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Surveys updated.');
        } else {
            $this->addFlash('error', 'Could not update surveys.');
        }

        return $this->redirectToRoute('panelist_show', ['id' => $panelist->getId()]);
    }

    #[Route('/{id}', name: 'panelist_delete', methods: ['POST'])]
    public function delete(Request $request, Panelist $panelist, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panelist->getId(), $request->request->get('_token'))) {
            $panelist->setDeletedAt(new \DateTimeImmutable());
            $em->flush();

            $this->addFlash('success', 'Panelist deleted.');
        }

        return $this->redirectToRoute('panelist_index');
    }
}
