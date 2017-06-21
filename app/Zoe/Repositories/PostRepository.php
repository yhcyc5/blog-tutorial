<?php

namespace Zoe\Repositories;

use Zoe\EloquentRepository;
use App\Post;

class PostRepository extends EloquentRepository
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function postCreate($user_id, $params)
    {
        $post = $this->model->create([
            'title' => $params['title'],
            'content' => $params['content'],
            'author' => $user_id,
        ]);

        return $post;
    }

    public function postUpdate($post_id, $params)
    {
        $post = $this->getById($post_id);
        $data = [
            'title' => $params['title'],
            'content' => $params['content'],
        ];
        $post->update($data);

        return $post;
    }

}