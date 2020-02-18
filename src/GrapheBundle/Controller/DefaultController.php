<?php

namespace GrapheBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\CalendarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Diff\DiffColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

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
    public function indexBackAction()
    {
        $em= $this->getDoctrine()->getManager();
        $Tasks =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'To do']);
        $Tasks1 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Doing']);
        $Tasks2 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Done']);
        $Tasks3 =$em->getRepository('TasksBundle:Tasks')->findBy(['etat'=>0,'status'=>'Block']);
        $user=$em->getRepository('MainBundle:User')->findAll();
        $pieChart = new PieChart();
        $size = count($user);
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
        $pieChart->getOptions()->setTitle('Tasks');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#16CABD');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $oldColumnChart = new ColumnChart();
        $oldColumnChart->getData()->setArrayToDataTable(
            [['Task', 'Task'],
                ['Done',     $sizeDone],
                ['Doing',      $sizeDoing],
                ['To Do',  $sizeToDo],
                ['Block', $sizeBlock],
            ]
        );
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



        return $this->render('@Tasks/Tasks/DailyB.html.twig', array(
            'oldColumnChart' => $oldColumnChart,
            'newColumnChart' => $newColumnChart,
            'piechart' => $pieChart

        ));
    }

    public function calendarAction()
    {
        $cal = new CalendarChart();
        $cal->getData()->setArrayToDataTable(
            [
                [['label' => 'Date', 'type' => 'date'], ['label' => 'Attendance', 'type' => 'number']],
                [ new DateTime('2012-03-13'), 37032 ],
                [ new DateTime('2012-03-14'), 38024 ],
                [ new DateTime('2012-03-15'), 38024 ],
                [ new DateTime('2012-03-16'), 38108 ],
                [ new DateTime('2012-03-17'), 38229 ],
                [ new DateTime('2012-03-18'), 38177 ],
                [ new DateTime('2012-03-19'), 38705 ],
                [ new DateTime('2012-03-20'), 38210 ],
                [ new DateTime('2012-03-21'), 38029 ],
                [ new DateTime('2012-03-22'), 38823 ],
                [ new DateTime('2012-03-23'), 38345 ],
                [ new DateTime('2012-03-24'), 38436 ],
                [ new DateTime('2012-03-25'), 38447 ]
            ]
        );
        $cal->getOptions()->setTitle('Red Sox Attendance');
        $cal->getOptions()->setHeight(350);
        $cal->getOptions()->setWidth(1000);
        $cal->getOptions()->getCalendar()->setCellSize(20);
        $cal->getOptions()->getCalendar()->getCellColor()->setStroke('#76a7fa');
        $cal->getOptions()->getCalendar()->getCellColor()->setStrokeOpacity(0.5);
        $cal->getOptions()->getCalendar()->getCellColor()->setStrokeWidth(1);
        $cal->getOptions()->getCalendar()->getFocusedCellColor()->setStroke('#d3362d');
        $cal->getOptions()->getCalendar()->getFocusedCellColor()->setStrokeOpacity(1);
        $cal->getOptions()->getCalendar()->getFocusedCellColor()->setStrokeWidth(1);
        $cal->getOptions()->getCalendar()->getDayOfWeekLabel()->setFontName('Times-Roman');
        $cal->getOptions()->getCalendar()->getDayOfWeekLabel()->setFontSize(12);
        $cal->getOptions()->getCalendar()->getDayOfWeekLabel()->setColor('#1a8763');
        $cal->getOptions()->getCalendar()->getDayOfWeekLabel()->setBold(true);
        $cal->getOptions()->getCalendar()->getDayOfWeekLabel()->setItalic(true);
        $cal->getOptions()->getCalendar()->setDayOfWeekRightSpace(10);
        $cal->getOptions()->getCalendar()->setDaysOfWeek('DLMMJVS');
        $cal->getOptions()->getCalendar()->getMonthLabel()->setFontName('Times-Roman');
        $cal->getOptions()->getCalendar()->getMonthLabel()->setFontSize(12);
        $cal->getOptions()->getCalendar()->getMonthLabel()->setColor('#981b48');
        $cal->getOptions()->getCalendar()->getMonthLabel()->setBold(true);
        $cal->getOptions()->getCalendar()->getMonthLabel()->setItalic(true);
        $cal->getOptions()->getCalendar()->getMonthOutlineColor()->setStroke('#981b48');
        $cal->getOptions()->getCalendar()->getMonthOutlineColor()->setStrokeOpacity(0.8);
        $cal->getOptions()->getCalendar()->getMonthOutlineColor()->setStrokeWidth(2);
        $cal->getOptions()->getCalendar()->getUnusedMonthOutlineColor()->setStroke('#bc5679');
        $cal->getOptions()->getCalendar()->getUnusedMonthOutlineColor()->setStrokeOpacity(0.8);
        $cal->getOptions()->getCalendar()->getUnusedMonthOutlineColor()->setStrokeWidth(1);
        $cal->getOptions()->getCalendar()->setUnderMonthSpace(16);
        $cal->getOptions()->getCalendar()->setUnderYearSpace(10);
        $cal->getOptions()->getCalendar()->getYearLabel()->setFontName('Times-Roman');
        $cal->getOptions()->getCalendar()->getYearLabel()->setFontSize(32);
        $cal->getOptions()->getCalendar()->getYearLabel()->setColor('#1A8763');
        $cal->getOptions()->getCalendar()->getYearLabel()->setBold(true);
        $cal->getOptions()->getCalendar()->getYearLabel()->setItalic(true);

        $this->render('@Tasks/Tasks/DailyB.html.twig', array('cal'=>$cal));
    }
}
