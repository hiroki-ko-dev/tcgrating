<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository
{
    public function composeSaveClause($blog, $request) {
        if (isset($request->game_id)) {
            $blog->game_id = $request->game_id;
        }
        if (isset($request->user_id)) {
            $blog->user_id = $request->user_id;
        }
        $blog->title   = $request->title;
        $blog->thumbnail_image_url    = $request->thumbnail_image_url;
        $blog->affiliate_url = $request->affiliate_url;
        $blog->body = $request->body;
        $blog->is_released = $request->is_released;
        $blog->save();
        return $blog;
    }

    public function create($request)
    {
        $blog = new Blog();
        return $this->composeSaveClause($blog, $request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $blog = $this->find($request->id);

        return $this->composeSaveClause($blog, $request);
    }

    public function composeWhereClause($request)
    {
        $query = Blog::query();
        $query->where('game_id', $request->game_id);
        if (isset($request->is_released)) {
            $query->where('is_released', $request->is_released);
        }
        return $query;
    }

    public function find($id): ?Blog
    {
        return Blog::find($id);
    }

    public function findByPreview($id): ?Blog
    {
        return Blog::where('id', '<=', $id)
            ->where('is_released', 1)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function findByNext($id): ?Blog
    {
        return Blog::where('id', '>=', $id)
            ->where('is_released', 1)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function findAll($request)
    {
        $query = $this->composeWhereClause($request);
        return $query->get();
    }

    public function findAllByPaginate($request, $paginate)
    {
        $query = $this->composeWhereClause($request);
        return $query->withCount('blogComment')
            ->OrderBy('updated_at', 'desc')
            ->paginate($paginate);
    }
}
