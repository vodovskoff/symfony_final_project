<?php

namespace App\Controller;
use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\BattleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="app_Player_index", methods={"GET"})
     */
    public function index(PlayerRepository $PlayerRepository): Response
    {
        //$mr = new ManagerRegistry();
        //$br = new BattleRepository($mr);

        //var_dump($PlayerRepository->countBattles(4));
        $PlayerCountOfBattles = array();
        foreach ($PlayerRepository->findAll() as $Player){
            $PlayerCountOfBattles[$Player->getId()]=$PlayerRepository->countBattles($Player->getId());
        }
        //var_dump($PlayerCountOfBattles);
        return $this->render('player/index.html.twig', [
            'Players' => $PlayerRepository->findAll(),
            'countOfBattles'=>$PlayerCountOfBattles,
        ]);
    }

    /**
     * @Route("/new", name="app_Player_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PlayerRepository $PlayerRepository): Response
    {
        $Player = new Player();
        $form = $this->createForm(PlayerType::class, $Player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Player->setDateOfRegistration(date("Y-m-d H:i:s"));
            $PlayerRepository->add($Player, true);

            return $this->redirectToRoute('app_Player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('player/new.html.twig', [
            'Player' => $Player,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_Player_show", methods={"GET"})
     */
    public function show(Player $Player): Response
    {
        return $this->render('player/show.html.twig', [
            'Player' => $Player,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_Player_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Player $Player, PlayerRepository $PlayerRepository): Response
    {
        $form = $this->createForm(PlayerType::class, $Player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $PlayerRepository->add($Player, true);

            return $this->redirectToRoute('app_Player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('player/edit.html.twig', [
            'Player' => $Player,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_Player_delete", methods={"POST"})
     */
    public function delete(Request $request, Player $Player, PlayerRepository $PlayerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Player->getId(), $request->request->get('_token'))) {
            $PlayerRepository->remove($Player, true);
        }

        return $this->redirectToRoute('app_Player_index', [], Response::HTTP_SEE_OTHER);
    }
}
