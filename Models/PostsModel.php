<?php

namespace App\Models;

class PostsModel extends Model
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $chapo;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $body;

    /**
     * @var
     */
    private $img;

    /**
     * @var
     */
    private $created_at;

    /**
     * @var
     */
    private $user_id;

    /**
     * @var
     */
    private $author;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): PostsModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param mixed $chapo
     */
    public function setChapo($chapo): PostsModel
    {
        $this->chapo = $chapo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): PostsModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): PostsModel
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): PostsModel
    {
        $this->img = $img;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): PostsModel
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): PostsModel
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): PostsModel
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return array|false
     */
    public function FindAllByDESC()
    {
        $query = $this->request('SELECT *
                               FROM ' . $this->table . '
                               ORDER BY posts.created_at DESC');

        return $query->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @return array
     */
    public function getALlPostWIthCountComment(): array
    {
        $items = $this->findAll();
        $array = [];
        foreach ($items as $item) {
            $commentModel = new CommentsModel();
            $comments = $commentModel->findBy(
                array(
                    'post_id' => $item->id,
                    'is_valid' => 0
                )
            );
            $data['post'] = $item;
            $data['comments'] = count($comments);
            $array[] = $data;
        }
        return $array;
    }
}
