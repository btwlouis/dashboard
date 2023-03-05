<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Template;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTicket;

class TicketController extends Controller
{
    public static function migrateChannels()
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
                // check if ticket exists
                $ticket = Ticket::where('channel_id', $channel->id)->first();

                if($ticket) {
                    continue;
                }

                $ticket = Ticket::firstOrCreate([
                    'channel_id' => $channel->id,
                    'name' => $channel->name,
                ]);
            }
        }
        
        $tickets = Ticket::all();

        foreach($tickets as $ticket) {
            if(!in_array($ticket->channel_id, array_column($channels, 'id'))) {
                $ticket->status = 'closed';
                $ticket->save();
            }
        }
    }

    public function index()
    {
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

        // show all admins with team permission
        $admins = User::all()->filter(function($user) {
            return $user->hasPermission('team');
        });

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

            $content = $content . " ^" . auth()->user()->name;

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

            // assign ticket to user if not already assigned
            if(!$ticket->assigned_to) {
                $user = auth()->user();
                $user->tickets()->save($ticket);
            }

            activity()->log('Nachricht an Ticket ' . $ticket->name . ' gesendet.');

            return redirect()->back()->with('success', 'Nachricht gesendet!');
        }

        return redirect()->back();
        
    }

    public function destroy(Request $request, $id) {
        $ticket = Ticket::findOrFail($id);

        $client = new Client();

        $headers = [
            'Content-type'  => 'application/json; charset=utf-8',
            'Accept'        => 'application/json',
            'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
        ];

        $res = $client->request('DELETE', env('DISCORD_API_URL') . '/channels/' . $ticket->channel_id, [
            'headers' => $headers,
        ]);

        $ticket->status = 'closed';
        $ticket->save();

        activity()->log('Ticket ' . $ticket->name . ' wurde geschlossen.');

        return redirect()->route('ticket.index')->with('success', 'Ticket geschlossen!');
    }

}
