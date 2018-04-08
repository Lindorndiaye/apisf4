<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


class BiensController extends Controller
{
  
    /**
     * @Route("/biens", name="biens")
     */
    public function index()
    {
        return $this->render('biens/index.html.twig', [
            'controller_name' => 'BiensController',
        ]);
    }
    /**
     * Lists all Biens
     * @FOSRest\Get("/biens")
     *
     * @return array
     */

    public function listBienAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeReservations = $em->getRepository('App:Images')->findAll();

        $data = $this->get('jms_serializer')->serialize($listeReservations, 'json');
        if (!empty($listeReservations)) {
            $requete = array(
                'code' => 1,
                'message' => '',
            );

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
           
        } else {
            $requete = array(
                'code' => 0,
                'message' => 'Aucun bien',
            );

            return new JsonResponse($requete, Response::HTTP_CREATED);
            
        }
       /*  return $this->render('biens/listBien.html.twig', [
            'controller_name' => 'BiensController',
        ],array('json' => $data ));*/

    }

    /**
     * @Route("/detailler/{id}")
     */
    public function detailAction($id)
    {
        if (!empty($id)){
        $detailBien = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Images')
        ->findBy(array('id' => $id));
        //echo count($detailreservation);
     $data = $this->get('jms_serializer')->serialize($detailBien, 'json');
        if (!empty($detailBien)) {
            $requete = array(
                'code' => 1,
                'message' => '',
            );

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
           
        } else {
            $requete = array(
                'code' => 0,
                'message' => 'Aucun bien',
            );

            return new JsonResponse($requete, Response::HTTP_CREATED);
            
        }
    }
    else{

    }
        
    
    }

    /**
     * @Route("/Reserve/{id}")
     */
    public function ReserveAction(Request $request, $id)
    {
        $reserve = new Reservation();

        $form = $this->get('form.factory')->create(ReservationType::class, $reserve);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $idClient = 1;
            $bien = $em->getRepository('App:Biens')->find($id);
            $client = $em->getRepository('App:Clients')->find($idClient);
            $em = $this->getDoctrine()->getManager();
            $date = date('Y-m-d');
            $reserve->setdateDeReservation($date);
            $reserve->setBien($bien);
            $reserve->setClient($client);
            $reserve->setEtat('0');
            $em->persist($reserve);

            $em->flush();
            $listeReservations = $em->getRepository('App:Reservations')->findAll();
            $reservations = $this->get('knp_paginator')->paginate(
        $listeReservations,
        $request->query->get('page', 1)/*le numéro de la page à afficher*/,
          4/*nbre d'éléments par page*/
    );

            return $this->redirectToRoute('valid');
        }

        return $this->render('App:Front:reserve.html.twig', array('form' => $form->createView(),
));
    }

    
}
