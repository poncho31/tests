<?php

namespace App\Controller;

use App\Models\Crypt;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{
    /**
     *@Route("/", name="home")
     */
    public function index(){
        $crypt = (new Crypt())->zip('application');
        return $this->render("home.html.twig");
    }


}