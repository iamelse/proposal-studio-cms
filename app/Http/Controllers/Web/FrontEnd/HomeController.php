<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FAQ;
use App\Models\Proposal;
use App\Models\Review;
use App\Models\Section;
use App\Models\Service;
use App\Models\VisitorStatistic;
use App\Models\WhyUs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $hero = Section::where('name', 'hero')->firstOrFail();
        $whyUsList = WhyUs::all();
        $about = Section::where('name', 'about')->firstOrFail();
        $ourService = Section::where('name', 'services')->firstOrFail();
        $services = Service::orderBy('order')->get();
        $callToAction = Section::where('name','cta')->firstOrFail();
        $proposal = Section::where('name', 'proposal')->firstOrFail();
        $proposals = Proposal::limit(20)->orderBy('created_at', 'desc')->get();
        $event = Section::where('name', 'event')->firstOrFail();
        $events = Event::limit(20)->orderBy('created_at', 'desc')->get();
        $review = Section::where('name', 'review')->firstOrFail();
        $reviews = Review::limit(20)->orderBy('created_at', 'desc')->get();
        $faq = Section::where('name', 'faq')->firstOrFail();
        $faqs = FAQ::limit(20)->orderBy('created_at', 'desc')->get();

        $this->_incrementVisitor();

        return view('pages.frontend.home.index', [
            'title' => 'Jasa Pembuatan Proposal Profesional - Proposal Studio',
            'hero' => $hero,
            'whyUsList' => $whyUsList,
            'about' => $about,
            'ourService' => $ourService,
            'services' => $services,
            'proposal' => $proposal,
            'proposals' => $proposals,
            'event' => $event,
            'events' => $events,
            'review' => $review,
            'reviews' => $reviews,
            'faq' => $faq,
            'faqs' => $faqs,
            'callToAction' => $callToAction
        ]);
    }

    protected function _incrementVisitor(): void
    {
        $today = Carbon::today()->toDateString();

        $stat = VisitorStatistic::where('date', $today)->first();

        if ($stat) {
            $stat->increment('visitors');
        } else {
            VisitorStatistic::create([
                'date' => $today,
                'visitors' => 1,
            ]);
        }
    }

    protected function _incrementDailyVisitor(): void
    {
        $cookieKey = 'daily_visitor_tracked';
        $today = Carbon::today()->toDateString();

        // Cek cookie agar tidak dihitung dua kali dalam sehari
        if (Cookie::has($cookieKey) && Cookie::get($cookieKey) === $today) {
            return;
        }

        // Cek apakah statistik untuk hari ini sudah ada
        $stat = VisitorStatistic::where('date', $today)->first();

        if ($stat) {
            $stat->increment('visitors');
        } else {
            VisitorStatistic::create([
                'date' => $today,
                'visitors' => 1,
            ]);
        }

        // Set cookie agar tidak dihitung lagi hari ini
        Cookie::queue($cookieKey, $today, 1440); // 1 hari
    }
}
