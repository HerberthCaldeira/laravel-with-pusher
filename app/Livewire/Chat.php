<?php

namespace App\Livewire;

use App\Events\NewMessageEvent;
use Livewire\Attributes\On;
use Livewire\Component;


class Chat extends Component
{
    public string $msg;
    public array $messages = [];
    public array $here = [];
    public function getListeners()
    {
        return [
            "echo-presence:chat,.new.message" => 'newMessage',
            "echo-presence:chat,here" => 'here',
            "echo-presence:chat,joining" => 'joining',
            "echo-presence:chat,leaving" => 'leaving',
        ];
    }

    public function here($payload)
    {
        $this->here = $payload;
    }
    public function joining($payload)
    {
        $this->here[] = $payload;
    }
    public function leaving($payload)
    {
        $this->here = array_filter($this->here, function ($value) use ($payload) { return $value['id'] !== $payload['id']; });
    }


    public function newMessage($payload)
    {
       array_unshift($this->messages,  $payload) ;
    }

    public function send()
    {
        NewMessageEvent::dispatch([
            'id'  => auth()->user()->id,
            'author'  => auth()->user()->name,
            'message' => $this->msg,
            'date'    => now()->format('Y-m-d H:i:s'),
        ]);

        $this->reset('msg');
    }
    public function render()
    {
        return view('livewire.chat');
    }
}
