<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HandleRoute extends Controller
{
    public function show_home(): View
    {
        return view('app_pages.guest.Home.index');
    }

    public function show_reserve_now(): View
    {
        return view('app_pages.guest.Reserve_now.index');
    }

    public function show_contact(): View
    {
        return view('app_pages.guest.Contact.index');
    }

    public function show_about_us(): View
    {
        return view('app_pages.guest.About_us.index');
    }

    public function show_faqs(): View
    {
        return view('app_pages.guest.Faqs.index');
    }

    public function show_terms_and_conditions(): View
    {
        return view('app_pages.guest.Terms_and_conditions.index');
    }

    public function show_privacy_notice(): View
    {
        return view('app_pages.guest.Privacy_notice.index');
    }

    public function show_rental_conditions(): View
    {
        return view('app_pages.guest.Rental_conditions.index');
    }

    public function show_gdpr(): View
    {
        return view('app_pages.guest.Gdpr.index');
    }

    public function show_return_policy(): View
    {
        return view('app_pages.guest.Return_policy.index');
    }

    public function show_cancellation_policy(): View
    {
        return view('app_pages.guest.Cancellation_policy.index');
    }

    public function show_cars(): View
    {
        return view('app_pages.guest.Cars.index');
    }

    public function show_airport_transfer(): View
    {
        return view('app_pages.guest.Airport_transfer.index');
    }

    public function show_car_fleet(): View
    {
        return view('app_pages.guest.Car_fleet.index');
    }

    public function show_dashboard(): View
    {
        return view('app_pages.auth.Dashboard.index');
    }

    public function show_in_work(): View
    {
        return view('common.inWork');
    }
}
