<?php

namespace App\Controller;

use App\Entity\Phweep;
use App\Form\PhweepType;
use App\Repository\PhweepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/phweep")
 */
class PhweepController extends AbstractController
{
    /**
     * @Route("/", name="phweep_index", methods="GET")
     */
    public function index(PhweepRepository $phweepRepository): Response
    {
        return $this->render('phweep/index.html.twig', ['phweeps' => $phweepRepository->findBy([], ['id' => 'DESC'])]);
    }

    /**
     * @Route("/new", name="phweep_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $phweep = new Phweep();
        $form = $this->createForm(PhweepType::class, $phweep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phweep);
            $em->flush();

            return $this->redirectToRoute('phweep_index');
        }

        return $this->render('phweep/new.html.twig', [
            'phweep' => $phweep,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="phweep_show", methods="GET")
     */
    public function show(Phweep $phweep): Response
    {
        return $this->render('phweep/show.html.twig', ['phweep' => $phweep]);
    }

    /**
     * @Route("/{id}/edit", name="phweep_edit", methods="GET|POST")
     */
    public function edit(Request $request, Phweep $phweep): Response
    {
        $form = $this->createForm(PhweepType::class, $phweep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phweep_index', ['id' => $phweep->getId()]);
        }

        return $this->render('phweep/edit.html.twig', [
            'phweep' => $phweep,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="phweep_delete", methods="DELETE")
     */
    public function delete(Request $request, Phweep $phweep): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phweep->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($phweep);
            $em->flush();
        }

        return $this->redirectToRoute('phweep_index');
    }
}
