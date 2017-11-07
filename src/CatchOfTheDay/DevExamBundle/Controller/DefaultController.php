<?php

namespace CatchOfTheDay\DevExamBundle\Controller;

use CatchOfTheDay\DevExamBundle\Model\TodoListItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');

        $text = $request->request->get('todo-text');

        if ($text == null || $text == '') {
            $result['success'] = false;
            $result['message'] = "New item cannot have empty text.";
        } else {
            $newItem = new TodoListItem();
            $newItem->setText($text);

            $manager->addNewItem($newItem);

            $result['success'] = true;
            $result['id'] = $newItem->getId();
            $result['message'] = "New item has been successfully added.";
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/items/{itemId}/mark-as-complete", name="mark_as_complete")
     *
     * @param Request $request
     * @param string $itemId
     * @return JsonResponse
     */
    public function markAsCompleteAction(Request $request, $itemId)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $item = $manager->findItemById($itemId);
        $result = [];

        if ($item == null) {
            $result['success'] = false;
            $result['message'] = "Item not found.";
        } else {
            $item->setComplete(true);
            $manager->updateItem($item);

            $result['success'] = true;
            $result['message'] = "The item has been marked as completed!";
        }

        return new JsonResponse($result);
    }
}
