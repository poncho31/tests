<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Repository\PropertyRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(PropertyRepository $repository): Response{
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'current_menu' => 'home',
            'properties'=> $properties
        ]);
    }
}