<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreRequest;
use Illuminate\Contracts\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        return view('app.template.index');
    }

    public function create(): View
    {
        return view('app.template.create');
    }

    public function edit(): View
    {
        return view('app.template.edit');
    }

    public function store(StoreRequest $request)
    {

    }

}
