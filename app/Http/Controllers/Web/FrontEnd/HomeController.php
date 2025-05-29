<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Skill;
use App\Models\WhyUs;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $hero = Section::where('name', 'hero')->firstOrFail();
        $whyUsList = WhyUs::all();
        $about = Section::where('name', 'about')->firstOrFail();
        $callToAction = Section::where('name','cta')->firstOrFail();

        return view('pages.frontend.home.index', [
            'title' => 'Home',
            'hero' => $hero,
            'whyUsList' => $whyUsList,
            'about' => $about,
            'callToAction' => $callToAction
        ]);
    }
}
