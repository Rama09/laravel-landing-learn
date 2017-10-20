<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\People;
use App\Portfolio;
use App\Service;

class IndexController extends Controller
{
    public function execute(Request $request)
    {
        $pages = Page::all();
        $portfolio = Portfolio::get(['name', 'filter', 'images']);
        $people = People::take(3)->get();
        $services = Service::where('id', '<', 20)->get();

        return view('site.index');
    }
}
