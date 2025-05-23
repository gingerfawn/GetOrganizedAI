<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Chats;
use App\Models\Notes;
use GeminiAPI\Laravel\Facades\Gemini;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

use Auth;




class ChatModule extends Component
{
    public $current_chat;
    public $web_crawl;
    public $crawler;
    public $note_id;
    public $history;
    public $user;
    public $current_profile;
    public $draft_folder;
    public $show = false;
    public $current_note_name;
    public $user_note;

    public function submitChat(){

        if( trim($this->current_chat) != '' || trim($this->web_crawl != '' || trim($this->user_note != ''))){

            //CREATE NEW NOTE if needed 
            if( $this->note_id == null ){
                $current_note = new Notes();
                $current_note->folder_id = $this->draft_folder->id;
                $current_note->name = Carbon::now()->format('l, M d');
                $current_note->save();
                $this->note_id = $current_note->id;
                $this->current_note_name = $current_note->name;
                $this->dispatch('refresh_sidenav');
            }

            $chats = $this->history;

            $history = [];
            if($chats != null){
                for($i=0; $i < count($chats); $i++){
                    //eliminate user notes from chat history
                    if($chats[$i]->attachement_type != 'user_note'){
                        if($i == 0 || $chats[$i]->is_AI_resp != $chats[$i-1]->is_AI_resp){
                            $history[] = ['message' => $chats[$i]->chat, 'role' => $chats[$i]->is_AI_resp];
                        };
                    }
                };
            }

            $chat= Gemini::startChat($history);

            if($this->web_crawl != null){
                // $temp_client = new HttpBrowser(HttpClient::create());  
                $temp_client = new HttpBrowser();  

                $crawler_response = $temp_client->request('GET', $this->web_crawl);
                $train = "Please use the following document as a reference for the folliwng conversation." . $crawler_response->filter('body')->text();
                $gemini_response = $chat->sendMessage($train);
                $gemini_response = Str::markdown($gemini_response);
            } 
            
            if($this->current_chat != null){
                $gemini_response = $chat->sendMessage($this->current_chat);
                $gemini_response = Str::markdown($gemini_response);
            }


            //CREATE CHAT
            //TODO: fix profile and folders!             
            $current_chat = new Chats();

            
            if ( $this->web_crawl != null ){
                $current_chat->chat = $this->web_crawl;
            } 
            if ( $this->current_chat != null ) {
                $current_chat->chat = htmlspecialchars($this->current_chat);
            }

            if ( $this->user_note != null ){
                $current_chat->chat = $this->user_note;
            }

            $current_chat->note_id = $this->note_id;
            $current_chat->order = time();
            $current_chat->user_id = $this->user->id;
            $current_chat->profile_id = $this->current_profile->id;
            $current_chat->folder_id = $this->draft_folder->id;
            $current_chat->is_AI_resp = 'user';

            if ($this->web_crawl != null){
                $current_chat->attachment_type = 'web_crawl';
            }          
            if ($this->current_chat != null){
                $current_chat->attachment_type = '';
            }
            if ($this->user_note != null){
                $current_chat->attachment_type = 'user_note';
            }
            $current_chat->filepath = '';
            $current_chat->name = '';
            $current_chat->save();
    
            if ($this->user_note == null){
                $response_chat = new Chats();
                $response_chat->chat = $gemini_response;
                $response_chat->note_id = $this->note_id;
                $response_chat->order = time();
                $response_chat->user_id = $this->user->id;
                $response_chat->profile_id = $this->current_profile->id;
                $response_chat->folder_id = $this->draft_folder->id;
                $response_chat->is_AI_resp = 'model';
                $response_chat->attachment_type = '';
                $response_chat->filepath = '';
                $response_chat->name = '';
                $response_chat->save();
            }
        }
            $this->history = Chats::where('note_id', $this->note_id)->orderBy('created_at', 'desc')->get();
            $this->current_chat = '';
            $this->web_crawl = '';
            $this->user_note = '';
    }

    #[On('edit_note')]
    public function getNoteHistory($note_id){
        $this->note_id = $note_id;
        $this->history = Chats::where('note_id', $this->note_id)->orderBy('created_at', 'desc')->get();
        $note = Notes::where('id', $this->note_id)->first();
        $this->current_note_name = $note->name;
    }

    public function trainAI(){
        if($this->web_crawl != ''){
            $client = new HttpBrowser(HttpClient::create());  
            $this->crawler = $client->request('GET', $this->web_crawl);
        }

        $dom_array = [];
        foreach($this->crawler as $c){
           $dom_array[] = $c->nodeName;
        };
        dd( $this->crawler->filter('body')->text(), $dom_array );

    }

    public function editNoteName(){
        $current_note = Notes::where('id', $this->note_id)->first();
        if(trim($this->current_note_name) != '' ){
            $current_note->name = ucwords($this->current_note_name);
            $current_note->save();
            $this->dispatch('refresh_sidenav');
        }
    }

    public function mount(){
        $this->user = Auth::user();
    }
    public function render()
    {      
        return view('livewire.chat-module')->with('history', $this->history);
    }
}
