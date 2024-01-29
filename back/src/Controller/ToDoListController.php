<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\BlocNote;
use App\Entity\ToDoList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ListType;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListController extends AbstractController
{
    #Importez d'abord l'interface SessionInterface 
#use Symfony\Component\HttpFoundation\Session\SessionInterface;
//public function __construct(SessionInterface $session)
  //  {    
        // Sauvegarder un attribue dans une session 
    //    $session->set('nom-attribue', 'valeur-attribue');

        // récupérer une valeur d'un attribue
      //  $my_attribute = $session->get('nom-attribue');

       /*Le Deuxiéme argument est la valeur par défaut de l'attribue 
       de la session si elle n'existe pas */
        //$my_attribute = $session->get('nom-attribue', 'valeur-pa-defaut');

        // Retourne la valeur de notre attribue de session avant de le supprimer
        //$my_value = $session->remove('nom-attribue');

        // Supprime tous les attribues de la session
        //$session->clear();

        // Retourne la valeur de notre attribue de session avant de le supprimer
        //$my_value = $session->remove('nom-attribue');

/*

        <!-- $session->getFlashBag()->add('error', 'Ceci est un message d'erreur');

$session->getFlashBag()->add('warning', 'Ceci est un warning');

$session->getFlashBag()->add('warning', 'Un autre message warning');

$session->getFlashBag()->add('success', 'Félicitationn !!'); -->

<!-- {# Afficher les messages de succès #} 
{% for message in app.flashes('success') %}
   <div class="alert alert-success">
       {{ message }}
    </div>
{% endfor %}

{# Afficher les messages d'erreur #} 
{% for message in app.flashes('error') %}
   <div class="alert alert-error">
       {{ message }}
    </div>
{% endfor %}

{# Afficher les messages de warning #} 
{% for message in app.flashes('warning') %}
   <div class="alert alert-warning">
     /  {{ message }}
    </div>
{% endfor %} -->*/

   // }


    /**
     * @Route("/", name="app_to_do_list")
     */
  public function index(Request $request)
 
    {  /*   $task="kdjjjfjf";
        $form = $this->createFormBuilder($task)
        ->add('task', TextType::class)
        ->add('dueDate', DateType::class)
        ->add('save', SubmitType::class, ['label' => 'Create Task'])
        ->getForm();
        */

      
          //  $request = $this->getRequest();
    
            // if ($request->attributes->has(Security::LAST_USERNAME)) {
            //     dd($request->attributes->get(Security::LAST_USERNAME, ''));
            // }else{
            //     echo ("hello");
            // }
    
            //return $request->hasSession() ? $request->getSession()->get(Security::LAST_USERNAME, '') : '';
            // $user = $this->get('security.token_storage')->getToken()->getUser();
            // $user = $this->get('security.token_storage')->getToken()->getUser();
            // $user->getUsername();
        // dd($user);
        //session start
        $utilisateur = $this->getUser();
        
       // dd($utilisateur);
         $session=$request->getSession();
         if ($session->has('nb_visite')){
             $nb_visite=$session->get('nb_visite')+1;
         }
         else{
             $nb_visite=1;
         }
         $session->set('nb_visite',$nb_visite);
        //  dd($session->all());
        // $panier=$session->get();
        //  dd($panier);
         $panier['id']=1;
         $session->set('panier',$panier);
        //  dd( $session->get('panier'));
        $form = $this->createForm(ListType::class);
        
        $todolist=$this->getDoctrine()->getRepository(BlocNote::class)->findAll();
        $did=$this->getDoctrine()->getRepository(ToDoList::class)->findAll();
        if($utilisateur){
        return $this->render('index.html.twig', [
            'form' => $form->createView(),
            'todolist'=>$todolist,
            'did'=>$did
        ]); }
        else{
            return $this->redirectToRoute('home');
        }
        //return new Response('bienvenue sur job.com');
        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ToDoListController.php',
        ]);*/
    }

     /**
     * @Route("/to/do/list/create", name="create.to_do")
     */
  public function create(): Response
  {  $form = $this->createForm(ListType::class);
      return $this->render('index.html.twig', [
          'form' => $form->createView()
      ]); 
      //return new Response('bienvenue sur job.com');
      /*return $this->json([
          'message' => 'Welcome to your new controller!',
          'path' => 'src/Controller/ToDoListController.php',
      ]);*/
  }

        /**
     * @Route("/to/do/list/store", name="store.to_do",methods={"POST"})
     */
    public function store(Request $request)
    {  $form = $this->createForm(ListType::class);

        $todo=trim($request->request->get('to_do'));
        $doing=trim($request->request->get('doing'));
        $did=trim($request->request->get('did'));

        if (empty($todo || $doing || $did)){
        return $this->redirectToRoute('app_to_do_list');
        }
        else{
        $entityManager=$this->getDoctrine()->getManager();
        $todolist=new BlocNote;
        $todolist->setTodo($todo);
        $todolist->setDoing($doing);
        $todolist->setDid($did);
        $entityManager->persist($todolist);
        
        $entityManager->flush();
        return $this->redirectToRoute('app_to_do_list');
        }

        //exit($request->request->get('my_title'));

       /* return $this->render('index.html.twig', [
            'form' => $form->createView()
        ]); */
        //return new Response('bienvenue sur job.com');
        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ToDoListController.php',
        ]);*/
    }

      /**
     * @Route("/to/do/list/edit", name="edit.to_do")
     */
    public function edit(): Response
    {  $form = $this->createForm(ListType::class);
        return $this->render('index.html.twig', [
            'form' => $form->createView()
        ]); 
        //return new Response('bienvenue sur job.com');
        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ToDoListController.php',
        ]);*/
    }

        /**
     * @Route("/to/do/list/update/todo={todo}&id={id}", name="update.to_do")
     */
  public function update($todo,$id)
  { //$did=trim($request->request->get('todo'));
    $entityManager=$this->getDoctrine()->getManager();
    $todolist=$entityManager->getRepository(BlocNote::class)->find($id);
    //$todolist->setStatus(! $todolist->getStatus());
  
     $list=new ToDoList;
        $list->setTitle($todo);
        
        $entityManager->persist($list);
        
        $entityManager->flush();
    
    
      
    return $this->redirectToRoute('app_to_do_list');
    
      //return new Response('bienvenue sur job.com');
      /*return $this->json([
          'message' => 'Welcome to your new controller!',
          'path' => 'src/Controller/ToDoListController.php',
      ]);*/
  }

          /**
     * @Route("/to/do/list/delete/{id}", name="delete.to_do")
     */
    public function delete(BlocNote $id)
    {  
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($id);
        $entityManager->flush();
      
        return $this->redirectToRoute('app_to_do_list');

        //return new Response('bienvenue sur job.com');
        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ToDoListController.php',
        ]);*/
    }

     /**
     * @Route("/home", name="home")
     */
  public function home(Request $request){
    return $this->render('home.html.twig'); 
  }
}
