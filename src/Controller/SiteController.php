<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Demande;
use App\Services\FileUploader;
use App\Repository\UserRepository;
use App\Repository\DemandeRepository;
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
        if($this->getUser()){
            if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }
        }else{
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('site/index.html.twig', [
            'voitures' => $repo->findAll(),
            'tops' => $repo->findBy(['isTop' => true]),

        ]);
    }

    #[Route('/location/{id}', name: 'app_loca_detail', methods: ['GET'])]
    public function detail(VoitureRepository $repo, $id): Response
    {
        return $this->render('site/detail.html.twig', [
            'voiture' => $repo->find($id),
            'tops' => $repo->findBy(['isTop' => true]),

        ]);
    }

    #[Route('/louer/{id}', name: 'app_louer', methods: ['GET'])]
    public function demande(VoitureRepository $repo, $id): Response
    {
        return $this->render('site/demande.html.twig', [
            'voiture' => $repo->find($id),
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

    
    #[Route('/inscription', name: 'app_inscription', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, UserRepository $userRepository, UserPasswordHasherInterface $encoder, FileUploader $service): Response
    {
        $user = new User();
        $data = $request->request->all();
        $file = $request->files->get('photo');
        if ($data) {
            $user->setPrenom($data['prenom'])
            ->setNom($data['nom'])
            ->setEmail($data['email'])
            ->setTelephone($data['phone'])
            ->setPassword($encoder->hashPassword($user, $data['password']))
            ->setRoles(["ROLE_CLIENT"]);

            if ($file) {
               $user->setPhoto($service->getUrl($service->upload($file)));
            }

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_loca_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('site/inscription.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/voiture/save', name: 'app_save_car')]
    public function save(Request $request, VoitureRepository $repoVoiture, DemandeRepository $repoDeamnde)
    {
        $data = $request->request->all();
       //dd($data);
        $demande = new Demande();
        if($data){
            $demande->setDateDebut(new \DateTime($data['debut']))
                    ->setDateFin(new \DateTime($data['fin']))
                    ->setPrixTotal($data['prix'])
                    ->setClient($this->getUser())
                    ->setStatut("EN COURS")
                    ->setVoiture($repoVoiture->find((int)$data['voiture']));

            $repoDeamnde->add($demande, true);

            return $this->redirectToRoute('app_mes_demandes', [], Response::HTTP_SEE_OTHER);
        }
    } 

    #[Route('/mes_demandes', name: 'app_mes_demandes')]
    public function mes_demandes(Request $request, VoitureRepository $repoVoiture, DemandeRepository $repoDeamnde)
    {
        $demandes = $repoDeamnde->findBy(['client' => $this->getUser()]);

        return $this->renderForm('site/mes_demandes.html.twig', [
            'demandes' => $demandes,
        ]);
    } 
}
