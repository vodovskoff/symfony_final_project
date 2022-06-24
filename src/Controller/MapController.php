<?php

namespace App\Controller;

use App\Entity\Map;
use App\Form\MapType;
use App\Repository\MapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/map")
 */
class MapController extends AbstractController
{
    /**
     * @Route("/", name="app_map_index", methods={"GET"})
     */
    public function index(MapRepository $mapRepository): Response
    {
        $mapCountOfBattles = array();
        foreach ($mapRepository->findAll() as $map){
            $mapCountOfBattles[$map->getId()]=$mapRepository->countBattles($map->getId());
        }
        return $this->render('map/index.html.twig', [
            'maps' => $mapRepository->findAll(),
            'mapBattles'=>$mapCountOfBattles,
        ]);
    }

    /**
     * @Route("/new", name="app_map_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MapRepository $mapRepository): Response
    {
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapRepository->add($map, true);

            return $this->redirectToRoute('app_map_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('map/new.html.twig', [
            'map' => $map,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_map_show", methods={"GET"})
     */
    public function show(Map $map): Response
    {
        return $this->render('map/show.html.twig', [
            'map' => $map,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_map_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Map $map, MapRepository $mapRepository): Response
    {
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapRepository->add($map, true);

            return $this->redirectToRoute('app_map_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('map/edit.html.twig', [
            'map' => $map,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_map_delete", methods={"POST"})
     */
    public function delete(Request $request, Map $map, MapRepository $mapRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$map->getId(), $request->request->get('_token'))) {
            $mapRepository->remove($map, true);
        }

        return $this->redirectToRoute('app_map_index', [], Response::HTTP_SEE_OTHER);
    }

}
