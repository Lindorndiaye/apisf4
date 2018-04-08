<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Localite;
use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Image;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }
   
    /**
     * Lists all Biens
     * @FOSRest\Get("/biens")
     *
     * @return array
     */
    public function getBienAction( Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Bien::class);
        // $repository = $this->getDoctrine()->getRepository(Image::class);
        
        // query for a single Product by its primary key (usually "id")
        $bien = $repository->findBy(['etat'=>0]);
        
        foreach($bien as $key=>$values){
            foreach($values->getImages() as $key1=>$images){ 
                $images->setImage(base64_encode(stream_get_contents($images->getImage())));
            }
        }
        if ($request->isMethod('POST')) {
            if ($_POST['localite'] != '' && $_POST['typebien'] != '' && $_POST['prixLocation'] != ''  ) {
                $listbien = $repository->findByValues($_POST['localite'], $_POST['typebien'],$_POST['prixLocation']);   
            }
    
        }
       
        if(!count($bien)){
            $response =array(
                "code"=>false,
                "msg"=>"liste des biens",
                "error"=>null,
                "data"=>null,
               
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($bien, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"liste des client",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );
        
 
    
    }
    /**
     * Create Client.
     * @FOSRest\Post("/client")
     *
     * @return array
     */
    public function postClientAction(Request $request)
    {
        $article = new Client();
        $article->setNumeropiece($request->get('numpiece'));
        $article->setNomclient($request->get('nomClient'));
        $article->setTelclient($request->get('tel'));
        $article->setAdresseclient($request->get('adresse'));
        $article->setEmailclient($request->get('email'));
        $article->setPassword($request->get('password'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return new Response('', Response::HTTP_CREATED);
        
    }
}