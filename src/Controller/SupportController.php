<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportType;
use App\Entity\ArchiveSupport;
use App\Repository\ArchiveSupportRepository;
use App\Repository\SupportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\DateTimeImmutable;

/**
 * @Route("/admin/support")
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
            $date = new \DateTimeImmutable();
            $support->setCreatedAt($date);
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
        if ($this->isCsrfTokenValid('delete' . $support->getId(), $request->request->get('_token'))) {

            $date = new \DateTimeImmutable();
            $support->setCreatedAt($date);

            $date = new \DateTimeImmutable();
            $archiveSupport = new ArchiveSupport();
            $archiveSupport->setUser($support->getUser());
            $archiveSupport->setTitle($support->getTitle());
            $archiveSupport->setInformations($support->getInformations());
            $archiveSupport->setVu($support->getVu());
            $archiveSupport->setStatus($support->getStatus());
            $archiveSupport->setCreatedAt($support->getCreatedAt());
            $archiveSupport->setSuppressedAt($date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($support);
            $entityManager->persist($archiveSupport);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Report Resolu');
        return $this->redirectToRoute('admin_gestion_user_article', [], Response::HTTP_SEE_OTHER);
    }
}
