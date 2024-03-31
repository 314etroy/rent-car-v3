<?php

namespace App\Http\Livewire\Pages\Guest;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Contact extends Component
{
    public $formFildsContent = [
        'nameSiPrenume' => '',
        'email' => '',
        'phone' => '',
        'subiect' => '',
        'mesaj' => '',
    ];

    public $errorMsgs;
    public $successMsg = false;
    function extractLastSegment()
    {
        $url = url()->previous();
        $segments = explode('/', rtrim($url, '/'));
        return ucfirst(end($segments));
    }

    public function handleSubmit()
    {
        $rules = [
            'nameSiPrenume' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'subject' => 'required',
            'mesaj' => 'required'
        ];

        $messages = [
            'nameSiPrenume.required' => 'Adauga nume si prenume',
            'email.required' => 'Adauga email',
            'email.email' => 'Campul email trebuie sa aiba formatul nume@adresa.com',
            'phone.numeric' => 'Campul telefon trebuie sa fie completat corect',
            'subject.required' => 'Adauga subiectul',
            'mesaj.required' => 'Adauga un mesaj',
        ];

        $validare = Validator::make($this->formFildsContent, $rules, $messages);

        if ($validare->errors()) {
            $this->errorMsgs = $validare->errors()->all();
            $this->reset('successMsg');
        }

        if (!$validare->fails()) {
            $this->successMsg = !$this->successMsg;
            $contact_details = $this->formFildsContent;
            Mail::send('emails.contact', ['details' => $contact_details], function ($message) use ($contact_details) {
                $message->from('no-replay@site.ro')->to(env('MAIL_TO'))->subject('Mesaj nou: ' . $contact_details['nameSiPrenume']);
            });
            $this->reset('formFildsContent');
        }
    }

    public function render(): View
    {
        return view('livewire.pages.guest.contact');
    }
}
