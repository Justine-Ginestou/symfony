<?php
//src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="wild_welcome")
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', ['welcomeMessage' => 'Bienvenue sur Wild Series']);
    }
}