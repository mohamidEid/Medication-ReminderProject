<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Page Controller
 *
 * Handles static and simple pages
 */
class PageController extends Controller
{
    /**
     * Show welcome page
     */
    public function welcome(): View
    {
        return view('welcome');
    }

    /**
     * Show dashboard
     */
    public function dashboard(): View
    {
        return view('dashboard');
    }

    /**
     * Show history page
     */
    public function history(): View
    {
        return view('history');
    }

    /**
     * Show schedule page
     */
    public function schedule(): View
    {
        return view('schedule');
    }

    /**
     * Show smart features page
     */
    public function smartFeatures(): View
    {
        return view('smart-features');
    }

    /**
     * Show companions page
     */
    public function companions(): View
    {
        return view('companions');
    }

    /**
     * Show SMS test page
     */
    public function smsTest(): View
    {
        return view('sms-test');
    }
}
