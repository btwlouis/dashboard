<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Template;
use Spatie\Activitylog\Models\Activity;

class TicketController extends Controller
{
    

    //
    public function index()
    {
        $client = new Client();

        $headers = [
            'Content-type'  => 'application/json; charset=utf-8',
            'Accept'        => 'application/json',
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ];

        $guildId = env('DISCORD_GUILD_ID');
        $channelId = [
            env('DISCORD_SUPPORT_CATEGORY_ID'),
            env('DISCORD_BUY_CATEGORY_ID'),
            env('DISCORD_CUSTOM_CATEGORY_ID')
        ];

        $res = $client->request('GET', env('DISCORD_API_URL') . '/guilds/' . $guildId . '/channels', [
            'headers' => $headers
        ]);

        $channels = json_decode($res->getBody()->getContents());

        // only show channels where parent_id is in $channelId

        foreach($channels as $channel) {
            if(in_array($channel->parent_id, $channelId)) {
                Ticket::firstOrCreate([
                    'channel_id' => $channel->id,
                    'name' => $channel->name,
                ]);
            }
        }

        // show open tickets
        $tickets = Ticket::where('status', 'open')->get();

        return view('ticket.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        $client = new Client();

        $headers = [
            'Content-type'  => 'application/json; charset=utf-8',
            'Accept'        => 'application/json',
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ];

        $res = $client->request('GET', env('DISCORD_API_URL') . '/channels/' . $ticket->channel_id . '/messages', [
            'headers' => $headers
        ]);

        $messages = json_decode($res->getBody()->getContents());

        // show all admins
        $admins = User::hasRole('team')->get();

        $templates = Template::all();

        return view('ticket.show', compact('ticket', 'messages', 'admins', 'templates'));
    }
    
    public function update(Request $request, $id) {
        $ticket = Ticket::findOrFail($id);
        
        if ($request->assigned_to) {
            $user = User::findOrFail($request->assigned_to);
            $user->tickets()->save($ticket);
        }

        activity()->log('Ticket ' . $ticket->name . ' wurde aktualisiert.');

        return redirect()->back()->with('success', 'Ticket aktualisiert!');
    }

    public function sendDiscordMessage(Request $request, $id) {
        $ticket = Ticket::findOrFail($id);

        if($request->content) {
            $content = $request->content;

            $content = $content . '\n\n*Geschrieben von ' . auth()->user()->name . '*';

            $client = new Client();

            $headers = [
                'Content-type'  => 'application/json; charset=utf-8',
                'Accept'        => 'application/json',
                'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
            ];
    
            $res = $client->request('POST', env('DISCORD_API_URL') . '/channels/' . $ticket->channel_id . '/messages', [
                'headers' => $headers,
                'body' => json_encode([
                    'content' => $content,
                    'username' => 'Support | ' . auth()->user()->name,
                ])
            ]);

            activity()->log('Nachricht an Ticket ' . $ticket->name . ' gesendet.');

            return redirect()->back()->with('success', 'Nachricht gesendet!');
        }

        return redirect()->back();
        
    }

}
