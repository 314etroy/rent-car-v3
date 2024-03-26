<?php

namespace App\Http\Livewire\Errors;

use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

class Error500 extends Component
{

    public function boot()
    {
        $this->setCookie('step', 0);
        $this->setCookie('options', null, 0);
    }

    private function setCookie(string $key, int|string|null $value, int $expires = 60): void
    {
        Cookie::queue($key, $value, $expires);
    }

    public function render()
    {
        return view('livewire.errors.error500');
    }
}
