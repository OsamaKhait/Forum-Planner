<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RoleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserManagerController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/admin/users', name: 'app_admin_user_list')]
    public function userList(Request $request): Response
    {
        $searchTerm = $request->query->get('search', '');
        $users = $this->userRepository->findBySearchTerm($searchTerm);

        return $this->render('user_manager/index.html.twig', [
            'users' => $users,
            'searchTerm' => $searchTerm
        ]);
    }

    #[Route('/admin/users/{id}/edit-role', name: 'app_admin_edit_user_role')]
    public function editUserRole(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le rôle de l\'utilisateur a été modifié avec succès.');

            return $this->redirectToRoute('app_admin_user_list');
        }

        return $this->render('user_manager/edit_user_role.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
