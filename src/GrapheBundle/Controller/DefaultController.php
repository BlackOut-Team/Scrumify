<?php

namespace GrapheBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em= $this->getDoctrine()->getManager();
        $pieChart = new PieChart();
        $Tasks =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'To do']);
        $Tasks1 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Doing']);
        $Tasks2 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Done']);
        $Tasks3 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Block']);
        $sizeToDo = count($Tasks);
        $sizeDone = count($Tasks2);
        $sizeDoing = count($Tasks1);
        $sizeBlock = count($Tasks3);
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'number'],
                ['Done',     $sizeDone],
                ['Doing',      $sizeDoing],
                ['To Do',  $sizeToDo],
                ['Block', $sizeBlock],
            ]
        );
        $pieChart->getOptions()->setTitle('Daily Activities');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#16CABD');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Tasks/Tasks/Daily.html.twig', array('piechart' => $pieChart));
    }
}
