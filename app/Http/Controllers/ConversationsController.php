<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Notifications\MessageReceived;
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

    /**
     *
     * @var AuthManager
     */
    private $auth;

    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->middleware('auth');
        $this->repo = $conversationRepository;
        $this->auth = $auth;
    }

    public function index()
    {
        return view('conversations/index');
    }

    public function show(User $user)
    {
        $me = $this->auth->user();
        $messages = $this->repo->getMessagesFor($me->id, $user->id)->paginate(6);
        $unread = $this->repo->unreadCount($me->id);
        if (isset($unread[$user->id])) {
            $this->repo->readAllFrom($user->id, $me->id);
            unset($unread[$user->id]);
        }

        return view('conversations/show', [
            'users' => $this->repo->getConversations($me->id),
            'user' => $user,
            'messages' => $messages,
            'unread' => $unread
        ]);
    }

    public function store(User $user, StoreMessageRequest $request)
    {
        $message = $this->repo->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );
        $user->notify(new MessageReceived($message));
        return redirect(route('conversations.show', ['id' => $user->id]));
    }
}
