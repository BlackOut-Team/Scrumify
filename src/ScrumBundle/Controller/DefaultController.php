<?php

namespace ScrumBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Proxies\__CG__\TeamBundle\Entity\team;
use ScrumBundle\Entity\Projet;
use SprintBundle\Entity\Sprint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\team_user;

class DefaultController extends Controller
{
    public function  AddPAction(Request $request)
    {
        $myproject=$this->getDoctrine()->getRepository(Projet::class)->findBy(['etat'=>1,'master_id'=>$this->getUser()]);
        $ownerproject=$this->getDoctrine()->getRepository(Projet::class)->findBy(['etat'=>1,'owner_id'=>$this->getUser()]);
      //  $team=$this->getDoctrine()->getRepository(Projet::class)->findBy(['team_id'=>$getT]);
    //    $membersproject=$this->getDoctrine()->getRepository(Projet::class)->findBy(['etat'=>1,'team_id'=>$team->get]);

        $p= new Projet();
        $f=$this->createForm('ScrumBundle\Form\ProjetType',$p);
        $f->handleRequest($request);
        if ($f->isSubmitted() && $f->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $p->setCreated(new \DateTime('now'));
            $p->setMasterId($this->getUser());
            $p->setEtat(1);

            $em->persist($p);
            $em->flush($p);

            return $this->redirectToRoute('addProject');

        }
        return $this->render('@Scrum/Default/createProject.html.twig',array(
            'f'=>$f->createView(),
            'myproject'=>$myproject,
            'ownerproject'=>$ownerproject,
       //    'memberproject'=>$membersproject
        ));

    }

    public function archiverPAction(Request $request, Projet $project){

        $em= $this->getDoctrine()->getManager();
        $project->setEtat(0);
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('addProject');

    }
    public function editPAction(Request $request, Projet $project){
        $editForm=$this->createForm('ScrumBundle\Form\ProjetType',$project);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('addProject');
        }
        return $this->render('@Scrum/Default/editP.html.twig', array(
            'edit_form' => $editForm->createView()
        ));
    }

    public function  showPAction(Request $request)
    {
        $project=$this->getDoctrine()->getRepository(Projet::class)->findAll();


        return $this->render('@Scrum/Back/projects.html.twig',array(
            'pp'=>$project

        ));

    }
    public function desarchiverPAction(Request $request, Projet $pp){

        $em= $this->getDoctrine()->getManager();
        $pp->setEtat(1);
        $em->persist($pp);
        $em->flush();
        return $this->redirectToRoute('showProject');

    }
    function searchPAction(Request $request){
         $projet=new Projet();
            $Form=$this->createFormBuilder($projet)
                ->add('Name')
                ->add('Recherche',SubmitType::class,
                    ['attr'=>['formvalidate'=>'formvalidate']])
                ->getForm();
            $Form->handleRequest($request);
            if($Form->isSubmitted()){
                $projet=$this->getDoctrine()->getRepository(Projet::class)->findBy(array('name'=>$projet->getName()));
            }
            return $this->render('@Projet/Default/createProject.html.twig',
                array('S'=>$Form->createView(),'p'=>$projet));


    }
    public function chartAction()
    {
        $em= $this->getDoctrine()->getManager();
        $pieChart = new PieChart();
        $Archive =$em->getRepository('ScrumBundle:Projet')->findBy(['etat'=>0]);
        $Active =$em->getRepository('ScrumBundle:Projet')->findBy(['etat'=>1]);

        $user=$em->getRepository('MainBundle:User')->findAll();

        $sizeAr = count($Archive);
        $sizeAc = count($Active);

        $size = count($user);
        $oldColumnChart = new ColumnChart();
        $oldColumnChart->getData()->setArrayToDataTable(
            [['Project', 'Project'],
                ['Archive',     $sizeAr],
                ['Active',      $sizeAc],

            ]
        );
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Task'],
                ['Archive',     $sizeAr],
                ['Active',      $sizeAc],
                ]
        );
        $pieChart->getOptions()->setTitle('Projects');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#16CABD');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $oldColumnChart->getOptions()->getLegend()->setPosition('top');
        $oldColumnChart->getOptions()->setWidth(450);
        $oldColumnChart->getOptions()->setHeight(250);

        $newColumnChart = new ColumnChart();
        $newColumnChart->getData()->setArrayToDataTable(
            [
                ['n', 'Member'],
                [ 'Number of members in team', $size]

            ]);
        $newColumnChart->setOptions($oldColumnChart->getOptions());



        return $this->render('@Scrum/Back/chart.html.twig', array(
            'oldColumnChart' => $oldColumnChart,
            'newColumnChart' => $newColumnChart,
            'piechart' => $pieChart

        ));
    }



}
