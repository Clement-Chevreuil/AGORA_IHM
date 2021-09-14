<?php

namespace App\Controller;

use App\Entity\Home;
use App\Form\HomeType;
use App\Repository\HomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index", methods={"GET"})
     */
    public function index(HomeRepository $homeRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'homes' => $homeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/index2", name="home_index2", methods={"GET"})
     */
    public function indexSecond(HomeRepository $homeRepository): Response
    {
        return $this->render('home/secondIndex.html.twig', [
            'homes' => $homeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="home_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $home = new Home();
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($home);
            $entityManager->flush();

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/new.html.twig', [
            'home' => $home,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="home_show", methods={"GET"})
     */
    public function show(Home $home): Response
    {
        return $this->render('home/show.html.twig', [
            'home' => $home,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="home_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Home $home): Response
    {
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/edit.html.twig', [
            'home' => $home,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="home_delete", methods={"POST"})
     */
    public function delete(Request $request, Home $home): Response
    {
        if ($this->isCsrfTokenValid('delete'.$home->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($home);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
    }
}
