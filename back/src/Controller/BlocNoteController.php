<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NoteBlocRepository;
use App\Repository\UserRepository;
use App\Entity\NoteBloc;
use App\Entity\User;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;

class BlocNoteController extends AbstractController
{
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/bloc-note", name="app_bloc_note")
     */
    public function index(NoteBlocRepository $noteBlocRepository,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $hasAccess = $this->isGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_USER');
        // $resultToDo=$noteBlocRepository->findAll();
        $qb = $noteBlocRepository->createQueryBuilder('nb');
        $qb->where("nb.type = 'to_do'");
        $resultToDo=$qb->getQuery()->getResult();
        $pagination = $this->paginator->paginate(
            $resultToDo, // Query à paginer
            $request->query->getInt('page', 1), // Numéro de page par défaut
            10 // Nombre d'éléments par page
        );
        // $result=$this->getDoctrine()->getRepository(NoteBloc::class)->findAll();
        return $this->render('bloc_note/index.html.twig',  [
            'listTodo' => $pagination,
        ]);
    }

    /**
     * @Route("/did/bloc-note", name="did_bloc_note")
     */
    public function didNote(NoteBlocRepository $noteBlocRepository): Response
    {
        // $resultToDo=$noteBlocRepository->findAll();

        $qb = $noteBlocRepository->createQueryBuilder('nb');
        $qb->where("nb.type = 'did'");
        $resultDid=$qb->getQuery()->getResult();
        // $result=$this->getDoctrine()->getRepository(NoteBloc::class)->findAll();
        $result=$this->renderView('bloc_note/did.html.twig',  [
            'listDid' => $resultDid
        ]);
        $output = ['success' => 1,
        'data' => $result
    ];

        return new JsonResponse($output); 
    }


        /**
     * @Route("/add/bloc-note", name="add_bloc_note")
     */
    public function create(NoteBlocRepository $noteBlocRepository,UserRepository $userRepository,Request $request): Response
    {
        
        // if ($this->getUser()) {
            //     return $this->redirectToRoute('target_path');
        // }
        // $the_date=date('Y-m-d H:i:s',strtotime($date_tr));
        try{
            $data = json_decode($request->getContent(), true);
            $todo=$data['todo'];
            $date=new DateTimeImmutable(); 
            
            $user=$userRepository->find(1);

            $entityManager=$this->getDoctrine()->getManager();
            $todolist= new NoteBloc();
            // $sell=$entityManager->getRepository(Transaction::class)->find($id);
            $todolist->setContenu($todo);
            // $todolist->setDoing($doing);
            $todolist->setType('to_do');
            $todolist->setUserId($user);
            $todolist->setCreatedAt($date);
            $todolist->setUpdatedAt($date);
            // $todolist->setTestDate(new \DateTime());
            $entityManager->persist($todolist);
            
            $entityManager->flush();
            $output = ['success' => 1,
                'msg' => 'creer avec succès'
            ];

        }
        catch(\Exception $e){
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                    'msg' =>$e->getMessage()
                ];
        }
        return new JsonResponse($output);      
    }

        /**
     * @Route("/edit/bloc-note/{id}", name="edit_bloc_note")
     */
    public function edit(NoteBlocRepository $noteBlocRepository,UserRepository $userRepository,Request $request,$id): Response
    {
         // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        try{
            $todo= $request->get('editTodo');
            $date=new DateTimeImmutable(); 

            $user=$userRepository->find(1);

            $entityManager=$this->getDoctrine()->getManager();
            $todolist=$noteBlocRepository->find($id);
            // $sell=$entityManager->getRepository(Transaction::class)->find($id);
            $todolist->setContenu($todo);
            // $todolist->setDoing($doing);
            $todolist->setType('to_do');
            $todolist->setUserId($user);
            $todolist->setUpdatedAt($date);
            $entityManager->persist($todolist);
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_bloc_note');

        }
        catch(\Exception $e){
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                    'msg' =>'erreur!'
                ];
            return $this->redirectToRoute('app_bloc_note');
        }
      
    }


    /**
     * @Route("/finish/bloc-note/{id}", name="finish_bloc_note")
     */
    public function finish(NoteBlocRepository $noteBlocRepository,UserRepository $userRepository,$id): Response
    {
         // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        try{

            $user=$userRepository->find(1);
            $date=new \DateTime();

            $entityManager=$this->getDoctrine()->getManager();
            $todolist=$noteBlocRepository->find($id);
            // $sell=$entityManager->getRepository(Transaction::class)->find($id);
            $todolist->setType('did');
            // $todolist->setDoing($doing);
            // $todolist->setUpdatedAt($date);

            $entityManager->persist($todolist);
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_bloc_note');

        }
        catch(\Exception $e){
            // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                    'msg' =>'erreur!'
                ];
            return $this->redirectToRoute('app_bloc_note');
        }
      
    }

      /**
     * @Route("/delete/bloc-note/{id}", name="delete_bloc_note")
     */
    public function destroy(NoteBlocRepository $noteBlocRepository,UserRepository $userRepository,Request $request,NoteBloc $noteBloc,$id): Response
    {

        try{
            $entityManager = $this->getDoctrine()->getManager();
            $todolist=$noteBlocRepository->find($id);
        // $todolist=$entityManager->getRepository(NoteBloc::class)->find($id);

            $entityManager->remove($todolist);
            $entityManager->flush();

            $output = ['success' => 1,
                'msg' => 'effacer avec succès'
            ];
            return $this->redirectToRoute('app_bloc_note');

        }
        catch(\Exception $e){
        // \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        $output = ['success' => 0,
                'msg' =>'erreur!'
            ];
            return $this->redirectToRoute('app_bloc_note');
        }
      
    }
}
