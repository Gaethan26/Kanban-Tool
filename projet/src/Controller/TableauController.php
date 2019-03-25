<?php

namespace App\Controller;

use App\Entity\Tableau;
use App\Form\TableauType;
use App\Repository\TableauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tableau")
 */
class TableauController extends AbstractController
{
    /**
     * @Route("/", name="tableau_index", methods={"GET"})
     */
    public function index(TableauRepository $tableauRepository): Response
    {
        return $this->render('tableau/index.html.twig', [
            'tableaus' => $tableauRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tableau_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tableau = new Tableau();
        $form = $this->createForm(TableauType::class, $tableau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($tableau->getTaches() as $taches){
                $taches->setTableau($tableau);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tableau);
            $entityManager->flush();

            return $this->redirectToRoute('tableau_index');
        }

        return $this->render('tableau/new.html.twig', [
            'tableau' => $tableau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tableau_show", methods={"GET"})
     */
    public function show(Tableau $tableau): Response
    {
        return $this->render('tableau/show.html.twig', [
            'tableau' => $tableau,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tableau_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tableau $tableau): Response
    {
        $form = $this->createForm(TableauType::class, $tableau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($tableau->getTaches() as $taches){
                $taches->setTableau($tableau);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tableau_index', [
                'id' => $tableau->getId(),
            ]);
        }

        return $this->render('tableau/edit.html.twig', [
            'tableau' => $tableau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tableau_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tableau $tableau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tableau->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tableau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tableau_index');
    }
}
