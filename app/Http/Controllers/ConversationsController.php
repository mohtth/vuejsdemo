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

    public function __construct(ConversationRepository $conversationRepository, AuthManager $authman)
    {
        $this->repo = $conversationRepository;
        $this->authman = $authman;
    }

    public function index()
    {
        return view('conversations/index', [
            'users' => $this->repo->getConversations($this->authman->user()->id)
        ]);
    }

    public function show(User $user)
    {
        return view('conversations/show', [
            'users' => $this->repo->getConversations($this->authman->user()->id),
            'user' => $user
        ]);
    }
}
