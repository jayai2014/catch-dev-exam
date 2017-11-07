<?php

namespace CatchOfTheDay\DevExamBundle\Manager;

use CatchOfTheDay\DevExamBundle\Model\TodoListItem;
use Symfony\Component\Config\Definition\Exception\Exception;

class TodoListManager
{
    const DATA_FILE = '@CatchOfTheDayDevExamBundle/Resources/data/todo-list.json';

    /**
     * @var \Symfony\Component\Config\FileLocatorInterface
     */
    private $fileLocator;

    /**
     * @param \Symfony\Component\Config\FileLocatorInterface $fileLocator
     */
    public function __construct($fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }

    /**
     * @return string
     */
    private function getDataFilePath()
    {
        return $this->fileLocator->locate(self::DATA_FILE);
    }

    /**
     * @return \CatchOfTheDay\DevExamBundle\Model\TodoListItem[]
     */
    public function read()
    {
        $jsonFile = $this->getDataFilePath();
        $jsonContents = file_get_contents($jsonFile);
        $allData = json_decode($jsonContents, true);
        $items = [];

        foreach ($allData as $data) {
            array_push($items, TodoListItem::fromAssocArray($data));
        }

        return $items;
    }

    /**
     * @param \CatchOfTheDay\DevExamBundle\Model\TodoListItem[] $items
     */
    public function write(array $items)
    {
        $allData = [];

        foreach ($items as $item) {
            array_push($allData, $item->toAssocArray());
        }

        $jsonContents = json_encode($allData, JSON_PRETTY_PRINT);
        $jsonFile = $this->getDataFilePath();
        file_put_contents($jsonFile, $jsonContents);
    }

    /**
     * Add a new item to the data file.
     * @param $item TodoListItem
     */
    public function addNewItem($item) {
        $items = $this->read();
        array_push($items, $item);
        $this->write($items);
    }

    /**
     * Finds the item by its id.
     * @param string $id
     * @return TodoListItem|null
     */
    public function findItemById($id) {
        $items = $this->read();

        foreach ($items as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Update an item's data.
     * @param $itemUpdate TodoListItem
     */
    public function updateItem($itemUpdate) {
        $items = $this->read();
        $index = 0;

        foreach ($items as $item) {
            if ($item->getId() == $itemUpdate->getId()) {
                break;
            }
            $index += 1;
        }

        if ($index == count($items)) {
            // Item not found
            throw new Exception("Item must exit to be updated!");
        }

        $items[$index] = $itemUpdate;
        $this->write($items);
    }
}
