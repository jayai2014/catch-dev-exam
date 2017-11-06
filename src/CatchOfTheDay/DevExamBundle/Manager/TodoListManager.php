<?php

namespace CatchOfTheDay\DevExamBundle\Manager;

use CatchOfTheDay\DevExamBundle\Model\TodoListItem;

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

        $jsonContents = json_encode($allData);
        $jsonFile = $this->getDataFilePath();
        file_put_contents($jsonFile, $jsonContents);
    }
}
