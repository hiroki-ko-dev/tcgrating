<?php

namespace App\Services;
use App\Repositories\PostRepository;

use Illuminate\Http\Request;

class PostService
{
    protected $post_repository;

    public function __construct(PostRepository $post_repository)
    {
        $this->post_repository = $post_repository;
    }

    public function createPost($request)
    {
        return $this->post_repository->create($request);
    }

    public function getPostsByPostCategoryAndPagination($category_id, $paginate)
    {
        return $this->post_repository->findAllByPostCategoryIdAndPagination($category_id, $paginate);
    }

}
