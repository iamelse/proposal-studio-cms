<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\Section;
use App\Models\Service;
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
        $ourService = Section::where('name', 'services')->firstOrFail();
        $services = Service::all();
        $callToAction = Section::where('name','cta')->firstOrFail();
        $proposal = Section::where('name', 'proposal')->firstOrFail();
        $proposals = Proposal::limit(20)->orderBy('created_at', 'desc')->get();
        $event = Section::where('name', 'event')->firstOrFail();

        return view('pages.frontend.home.index', [
            'title' => 'Home',
            'hero' => $hero,
            'whyUsList' => $whyUsList,
            'about' => $about,
            'ourService' => $ourService,
            'services' => $services,
            'proposal' => $proposal,
            'proposals' => $proposals,
            'event' => $event,
            'callToAction' => $callToAction
        ]);
    }
}
