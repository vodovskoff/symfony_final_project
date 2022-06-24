<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Form\TankType;
use App\Repository\TankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tank")
 */
class TankController extends AbstractController
{
    /**
     * @Route("/", name="app_tank_index", methods={"GET"})
     */
    public function index(TankRepository $tankRepository): Response
    {
        return $this->render('tank/index.html.twig', [
            'tanks' => $tankRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_tank_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TankRepository $tankRepository): Response
    {
        $tank = new Tank();
        $form = $this->createForm(TankType::class, $tank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tankRepository->add($tank, true);

            return $this->redirectToRoute('app_tank_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tank/new.html.twig', [
            'tank' => $tank,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tank_show", methods={"GET"})
     */
    public function show(Tank $tank): Response
    {
        return $this->render('tank/show.html.twig', [
            'tank' => $tank,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_tank_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tank $tank, TankRepository $tankRepository): Response
    {
        $form = $this->createForm(TankType::class, $tank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tankRepository->add($tank, true);

            return $this->redirectToRoute('app_tank_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tank/edit.html.twig', [
            'tank' => $tank,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tank_delete", methods={"POST"})
     */
    public function delete(Request $request, Tank $tank, TankRepository $tankRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tank->getId(), $request->request->get('_token'))) {
            $tankRepository->remove($tank, true);
        }

        return $this->redirectToRoute('app_tank_index', [], Response::HTTP_SEE_OTHER);
    }
}
