<?php

namespace App\Models;

class CommentsModel extends Model
{
    protected $id;
    protected $comment;
    protected $post_id;
    protected $comment_date;
    protected $is_valid;
    protected $author_id;


    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));

    }

    public function updateValidComment() {
        $this->update();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param $id
     * @return $this
     */
    public function setId($id): CommentsModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * @param $comment
     * @return $this
     */
    public function setComment($comment): CommentsModel
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }


    /**
     * @param $post_id
     * @return $this
     */
    public function setPostId($post_id): CommentsModel
    {
        $this->post_id = $post_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->comment_date;
    }


    /**
     * @param $comment_date
     * @return $this
     */
    public function setCommentDate($comment_date): CommentsModel
    {
        $this->comment_date = $comment_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsValid()
    {
        return $this->is_valid;
    }


    /**
     * @param $is_valid
     * @return $this
     */
    public function setIsValid($is_valid): CommentsModel
    {
        $this->is_valid = $is_valid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }


    /**
     * @param $author_id
     * @return $this
     */
    public function setAuthorId($author_id): CommentsModel
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @param $id
     * @return array|false
     */
    public function findByPostId($id) {
        $query = $this->request('SELECT * FROM comments c, users u 
            WHERE c.post_id = '. $id . ' AND u.id = c.author_id AND c.is_valid = 1
            ORDER BY c.comment_date DESC;');

        return $query->fetchAll();
    }
}
