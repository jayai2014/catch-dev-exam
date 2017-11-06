<?php

namespace CatchOfTheDay\DevExamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        return [
            'items' => $items,
        ];
    }

    /**
     * @Route("/add", name="add")
     * @Method("POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();
        
        // TODO - Read the new item's text from $request, add a new TodoListItem to the collection and save.

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/items/{itemId}/mark-as-complete", name="mark_as_complete")
     *
     * @param Request $request
     * @param string $itemId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markAsCompleteAction(Request $request, $itemId)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        // TODO - Look in $items for the item that matches $itemId, update it and save the collection.

        return $this->redirectToRoute('index');
    }
}
