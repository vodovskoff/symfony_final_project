<?php

namespace App\Controller;

use App\Entity\Nation;
use App\Form\NationType;
use App\Repository\NationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nation")
 */
class NationController extends AbstractController
{
    /**
     * @Route("/", name="app_nation_index", methods={"GET"})
     */
    public function index(NationRepository $nationRepository): Response
    {
        $nationsCountOftanks = array();
        foreach ($nationRepository->findAll() as $nation){
            $nationsCountOftanks[$nation->getId()]=$nationRepository->countTanks($nation->getId());
        }
        return $this->render('nation/index.html.twig', [
            'nations' => $nationRepository->findAll(),
            'nationCount'=>$nationsCountOftanks,
        ]);
    }

    /**
     * @Route("/new", name="app_nation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NationRepository $nationRepository): Response
    {
        $nation = new Nation();
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nationRepository->add($nation, true);

            return $this->redirectToRoute('app_nation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nation/new.html.twig', [
            'nation' => $nation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nation_show", methods={"GET"})
     */
    public function show(Nation $nation): Response
    {
        return $this->render('nation/show.html.twig', [
            'nation' => $nation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_nation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Nation $nation, NationRepository $nationRepository): Response
    {
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nationRepository->add($nation, true);

            return $this->redirectToRoute('app_nation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nation/edit.html.twig', [
            'nation' => $nation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nation_delete", methods={"POST"})
     */
    public function delete(Request $request, Nation $nation, NationRepository $nationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nation->getId(), $request->request->get('_token'))) {
            $nationRepository->remove($nation, true);
        }

        return $this->redirectToRoute('app_nation_index', [], Response::HTTP_SEE_OTHER);
    }
}
