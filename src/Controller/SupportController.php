<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportType;
use App\Repository\SupportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/support")
 */
class SupportController extends AbstractController
{
    /**
     * @Route("/", name="support_index", methods={"GET"})
     */
    public function index(SupportRepository $supportRepository): Response
    {
        return $this->render('support/index.html.twig', [
            'supports' => $supportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="support_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $support = new Support();
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $support->setVu(false);
            $support->setStatus("En cours");
            $support->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($support);
            $entityManager->flush();

            $this->addFlash('success', 'Votre message sera transmis au plus vite au administrateur du site et vous repondrons par mail si besoin Bonne continuation et merci');
            return $this->redirectToRoute('article_index');
        }

        return $this->renderForm('support/new.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="support_show", methods={"GET"})
     */
    public function show(Support $support): Response
    {
        return $this->render('support/show.html.twig', [
            'support' => $support,
        ]);
    }

    /**
     * @Route("/{id}", name="support_delete", methods={"POST"})
     */
    public function delete(Request $request, Support $support): Response
    {
        if ($this->isCsrfTokenValid('delete'.$support->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($support);
            $entityManager->flush();
        }

        return $this->redirectToRoute('support_index', [], Response::HTTP_SEE_OTHER);
    }
}
