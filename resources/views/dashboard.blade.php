<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <div id="chat-display"></div>


                </div>
            </div>
        </div>
    </div>

    @push('my-js')


        <script>
            document.addEventListener('DOMContentLoaded', function (){
                console.log('EVENTS PUSHER');
                Echo.join(`chat`)
                    .here((users) => {
                        console.log('subscribed To Presence Channel', users)
                    })
                    .joining((user) => {
                        console.log(user.name);
                    })
                    .leaving((user) => {
                        console.log(user.name);
                    })
                    .error((error) => {
                        console.error(error);
                    })
                    .listen('.new.message', (e) => {
                        console.log(e)
                    })
                  ;

                Echo.private(`App.Models.User.{{auth()->user()->id}}`)
                    .subscribed(function(){
                        console.log('subscribed To Private Channel')
                    })
                    .listen('.do.somethig', (e) => {
                        console.log(e);
                    });
            })


        </script>



    @endpush


</x-app-layout>
