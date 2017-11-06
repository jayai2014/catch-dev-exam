<?php

namespace CatchOfTheDay\DevExamBundle\Model;

class TodoListItem
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $complete;

    public function __construct()
    {
        // TODO - Generate an identifier for this TodoListItem

        $this->created = new \DateTime();
        $this->complete = false;
    }

    /**
     * @return mixed
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $complete
     * @return TodoListItem
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * @param \DateTime $created
     * @return TodoListItem
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param string $id
     * @return TodoListItem
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $text
     * @return TodoListItem
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param array $data
     * @return TodoListItem
     */
    public static function fromAssocArray(array $data)
    {
        $item = new TodoListItem();

        // TODO

        return $item;
    }

    /**
     * @return array
     */
    public function toAssocArray()
    {
        $data = [];

        // TODO

        return $data;
    }
}