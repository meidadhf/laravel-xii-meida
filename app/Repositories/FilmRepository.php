<?php
namespace App\Repositories;

use App\Interfaces\FilmRepositoryInterface;
use App\Models\Film;

class FilmRepository implements FilmRepositoryInterface
{
    public function index()
    {
        return Film::all();
    }

    public function getById($id)
    {
        return Film::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return Film::whereId($id)->update($data);
    }

    public function delete($id)
    {
        return Film::destroy($id);
    }

    public function store(array $data)
    {
        return Film::create($data);
    }
}
