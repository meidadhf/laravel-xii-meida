<?php

namespace App\Interfaces;
use App\Repositories\FilmRepository;

interface FilmRepositoryInterface

{
    //
    public function index();
    public function getById($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
