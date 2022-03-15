<?php

namespace App\Models;

class CommentsModel extends Model
{
    protected $comment_id;
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

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->comment_id;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->comment_date;
    }

    /**
     * @param mixed $comment_date
     */
    public function setCommentDate($comment_date): void
    {
        $this->comment_date = $comment_date;
    }

    /**
     * @return mixed
     */
    public function getIsValid()
    {
        return $this->is_valid;
    }

    /**
     * @param mixed $is_valid
     */
    public function setIsValid($is_valid): void
    {
        $this->is_valid = $is_valid;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id): void
    {
        $this->author_id = $author_id;
    }

    public function findByPostId($id) {
        $query = $this->request('SELECT * FROM comments c, users u 
            WHERE c.post_id = '. $id . ' AND u.id = c.author_id AND c.is_valid = 1
            ORDER BY c.comment_date DESC;');

        return $query->fetchAll();
    }


}
