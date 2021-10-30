<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\mMessage;
use Livewire\WithPagination;


class AdminMessage extends Component
{
    use WithPagination;

    public function render()
    {
        $datas = mMessage::orderBy('id', 'desc')->paginate(5);
        return view('livewire.pages.admin-message', compact('datas'))->layout('layouts.template1');
    }
}
