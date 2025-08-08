<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Client;
use App\Models\ContactUs;
use App\Models\GuestMessage;
use App\Models\MainContent;
use App\Models\Portfolio;
use App\Models\PortfolioDetail;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $about = About::first();
        $mainContent = MainContent::first();
        $product1 = Product::where('name', 'Web application using various technology')->first();
        $product2 = Product::where('name', 'Flutter for Mobile application')->first();
        $product3 = Product::where('name', 'Design Figma')->first();
        $product4 = Product::where('name', 'Private Course Online')->first();
        $clients = Client::all();
        $services = Service::all();
        $quotes = Quote::all();
        $portfoliosWeb = Portfolio::where('category', 'web')->get();
        $portfoliosMobile = Portfolio::where('category', 'mobile')->get();
        $portfoliosDesign = Portfolio::where('category', 'design')->get();
        $portfoliosCourse = Portfolio::where('category', 'course')->get();
        $teams = Team::all();
        $contactUs = ContactUs::first();

        return view('pages.index', compact(
            'about',
            'mainContent',
            'product1',
            'product2',
            'product3',
            'product4',
            'clients',
            'services',
            'quotes',
            'portfoliosWeb',
            'portfoliosMobile',
            'portfoliosDesign',
            'portfoliosCourse',
            'teams',
            'contactUs'
        ));
    }

    public function guestMessage(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        GuestMessage::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message']
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function portfolioDetail($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $contactUs = ContactUs::first();

        $detailImage = $portfolio->portfolioDetails()->where('type', 'image')->get();
        $detailVideo = $portfolio->portfolioDetails()->where('type', 'video')->get();

        return view('pages.portfolioDetail', compact(
            'portfolio',
            'contactUs',
            'detailImage',
            'detailVideo'
        ));
    }
}
