<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\FileUploader;
use App\Repository\UserRepository;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/users')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $datas = $userRepository->findAll();
        $users = [];
        foreach($datas as $data){
            if($data->getRoles()[0] == "ROLE_ADMIN"){
                $users[]=$data;
            }
            
        }
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/clients', name: 'app_client', methods: ['GET'])]
    public function client(UserRepository $userRepository): Response
    {
        $datas = $userRepository->findAll();
        $clients = [];
        foreach($datas as $data){
            if($data->getRoles()[0] == "ROLE_CLIENT"){
                $clients[]=$data;
            }
            
        }
        return $this->render('user/client.html.twig', [
            'users' => $clients,
        ]);
    }

    #[Route('/demandes', name: 'app_demandes', methods: ['GET'])]
    public function demande(DemandeRepository $repoDemande)
    {
        $demandes = $repoDemande->findAll();
        
        return $this->render('user/demande.html.twig', [
            'demandes' => $demandes,
        ]);
    }


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
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
            ->setRoles(["ROLE_ADMIN"]);

            if ($file) {
               $user->setPhoto($service->getUrl($service->upload($file)));
            }

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/demande/{id}', name: 'app_demande_valide', methods: ['GET'])]
    public function valider(DemandeRepository $repoDemande, $id, EntityManagerInterface $em): Response
    {
        $demande = $repoDemande->find($id);
        $demande->setStatut('VALIDER');
        $demande->getVoiture()->setIsdisponible(false);
        $em->flush();
        return $this->redirectToRoute('app_demandes', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/demande/end/{id}', name: 'app_demande_end', methods: ['GET'])]
    public function end(DemandeRepository $repoDemande, $id, EntityManagerInterface $em): Response
    {
        $demande = $repoDemande->find($id);
        $demande->setStatut('TERMINER');
        $demande->getVoiture()->setIsdisponible(true);
        $em->flush();
        return $this->redirectToRoute('app_demandes', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
