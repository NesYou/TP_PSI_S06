<?php
    
namespace OC\PlatformBundle\Controller;
    
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertEditType;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
    
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;


    
class AdvertController extends Controller {
    
    public function testAction(){
        $advert = new Advert();
        $advert->setTitle("Recherche développeur !");
        $advert->setAuthor("Jean");
        $advert->setContent("Recherche un développeur !");

        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush(); // C'est à ce moment qu'est généré le slug

        return new Response('Slug généré : '.$advert->getSlug());
        // Affiche « Slug généré : recherche-developpeur »
    }
    
    public function indexAction($page) {
               
        $nbPerPage = 3;
        
        //Ici, on récupére la liste des annonces, puis on la passe au template
        $listAdverts = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('OCPlatformBundle:Advert')
                        ->getAdverts($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listAdverts) / $nbPerPage);
        
        //Une page ne peut être négative
        if($page > $nbPages) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
                       
        //Appel du template index.html.twig
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }
        
    public function viewAction($id) {
        
        $em = $this->getDoctrine()->getManager();
            
        //On récupère l'annonce $id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
            
        if(null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
            
        //On récupère la liste des candidatures de cette annonce
        $listApplications = $em
                ->getRepository('OCPlatformBundle:Application')
                ->findBy(array('advert' => $advert))
        ;
            
        //On récupère la liste des AdvertSkill
        $listAdvertSkills = $em
                ->getRepository('OCPlatformBundle:AdvertSkill')
                ->findBy(array('advert' => $advert))
        ;
            
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills
        ));
            
    }
        
     public function addAction(Request $request) {
        // On crée un objet Advert
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);

        // Si la requête est en POST
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          
            // On enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }
        
    public function editAction($id, Request $request) {
        
        $em = $this->getDoctrine()->getManager();    
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        $form = $this->createForm(AdvertEditType::class, $advert);
            
        if(null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
            
//        $listCategories = $em->getRepository('OCPlatformBundle:Category')->findAll();
//            
//        foreach($listCategories as $category) {
//            $advert->addCategory($category);
//        }
            
            
        //Si la requête est en POST, c'est que le visiteur qui a soumis le formulaire
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée');
            return $this->redirectToRoute('oc_platform_view', array('id' => $id));
        }
            
        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'form'      => $form->createView(),
            'advert'    => $advert,
        ));
    }
        
    public function deleteAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
            
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
            
        foreach($advert->getCategories() as $category) {
            $advert->removeCategory($category);
        }
            
        $em->flush();
            
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }
        
    public function menuAction($limit) {
        
        $em = $this
                ->getDoctrine()
                ->getManager()
        ;
            
        $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
                array(),                    //Pas de critère
                array('date' => 'desc'),    //On trie par date décroissante
                $limit,                     //On sélectionne $limit annonces
                0                           //A partir du premier
        );
            
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }    
}