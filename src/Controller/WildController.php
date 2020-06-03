<?php
//src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index(): Response
    {
        return $this->render('wild/home.html.twig', ['website' => 'Wild Series']);
    }

    /**
     * @Route("/wild/show/{slug}", requirements={"slug"="[a-z0-9-]+"}, name="wild_slug")
     */
    public function show($slug = ''): Response
    {
        if($slug == ''){
            $slug = "Aucune série sélectionnée, veuillez choisir une série";
            return $this->render("wild/show.html.twig", ['slug'=>$slug]);
        }else{
            $slug = ucwords(str_replace('-', ' ', $slug));
            return $this->render("wild/show.html.twig", ['slug'=>$slug]);
        }
    }
}