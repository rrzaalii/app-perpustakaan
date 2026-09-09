<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(): string
    {
        return 'BookController@index';
    }

    public function create(): string
    {
        return 'BookController@create';
    }

    public function store(Request $request): string
    {
        return 'BookController@store';
    }

    public function show(string $id): string
    {
        return "BookController@show, id: {$id}";
    }

    public function edit(string $id): string
    {
        return "BookController@edit, id: {$id}";
    }

    public function update(Request $request, string $id): string
    {
        return "BookController@update, id: {$id}";
    }

    public function destroy(string $id): string
    {
        return "BookController@destroy, id: {$id}";
    }
}