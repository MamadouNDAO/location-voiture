<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\FileUploader;
use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SiteController extends AbstractController
{
    #[Route('/', name: 'app_loca_index', methods: ['GET'])]
    public function index(VoitureRepository $repo): Response
    {
        return $this->render('site/index.html.twig', [
            'voitures' => $repo->findAll(),
            'tops' => $repo->findAll(array('prix' => 'DESC'), 6, 0),

        ]);
    }

    #[Route('/location/{id}', name: 'app_loca_detail', methods: ['GET'])]
    public function detail(VoitureRepository $repo, $id): Response
    {
        return $this->render('site/detail.html.twig', [
            'voiture' => $repo->find($id),
            'tops' => $repo->findBy(array('type' => 'Bus'), array('prix' => 'DESC'), 3, 0),

        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login()
    {
        return $this->render('site/login.html.twig', [
            

        ]);
    }

    #[Route('/deconnexion', name: 'app_logout')]
    public function logout()
    {

    } 
}
