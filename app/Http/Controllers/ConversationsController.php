<?php

namespace App\Http\Controllers;

use App\User;
use App\Repository\ConversationRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\User as IlluminateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller
{
    /**
     * @var ConversationRepository
     */
    private $repo;

    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->repo = $conversationRepository;
        $this->auth = $auth;
    }

    public function index()
    {
        return view('conversations/index', [
            'users' => $this->repo->getConversations($this->auth->user()->id)
        ]);
    }

    public function show(User $user)
    {
        return view('conversations/show', [
            'users' => $this->repo->getConversations($this->auth->user()->id),
            'user' => $user,
            'messages' => $this->repo->getMessagesFor($this->auth->user()->id, $user->id)->get()->reverse()
        ]);
    }

    public function store(User $user, Request $request)
    {
        $this->repo->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );
        return redirect(route('conversations.show', ['id' => $user->id]));
    }
}
