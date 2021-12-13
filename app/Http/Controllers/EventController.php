<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $busca = request('search');
        $events = $busca ? Event::where([['title', 'like', '%' . $busca . '%']])->get() : Event::all();
        $dados = ['events' => $events, 'busca' => $busca];
        return view('welcome', $dados);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;
        $event->date = $request->date;
        $event->user_id = auth()->user()->id;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . '.' . $extension);
            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }
        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();
        $hasUserJoined = false;
        if ($user){
            $userEvents = $user->eventAsParticipants->toArray();
            foreach($userEvents as $userEvent){
                if ($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }
        }
        $eventOwner = User::select('name')->where('id', $event->user_id)->first()->toArray();
        $dados = [
            'event' => $event,
            'eventOwner' => $eventOwner,
            'hasUserJoined' => $hasUserJoined
        ];
        return view('events.show', $dados);
    }

    public function dashboard()
    {
        $user = auth()->user();

        $events = $user->events;
        $eventsAsParticipants = $user->eventAsParticipants;
        $dados = [
            'events' => $events,
            'eventsAsParticipants' => $eventsAsParticipants
        ];
        return view('events.dashboard', $dados);
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        if (auth()->user()->id != $event->user_id){
            return redirect('/dashboard');
        }
        $dados = [
            'event' => $event
        ];
        return view('events.edit', $dados);
    }

    public function update(Request $request)
    {
        $data = $this->save_image($request);
        Event::findOrFail($request->id)->update($data);
        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    public function joinEvent($id)
    {
        $user = auth()->user();
        $user->eventAsParticipants()->attach($id);
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
    }

    public function leaveEvent($id){
        $user = auth()->user();
        $user->eventAsParticipants()->detach($id);
        $event = Event::findOrFail($id);
        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento ' . $event->title);
    }

    private function save_image($request)
    {
        $data = $request->all();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . '.' . $extension);
            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;
        }
        return $data;
    }
}
