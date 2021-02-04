<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        Auth::loginUsingId($request->route('id'));
        if (!hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            return response(['error' => 'This action is unauthorized.']);
        }

        if (!hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            return response(['error' => 'This action is unauthorized.'], 322);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response(['error' => 'Email is already verified'], 322);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return response(['message' => 'Email Verified']);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response(['message' => 'already verified']);
        }

        $request->user()->sendEmailVerificationNotification();

        return response(['message' => 'email Sent']);
    }
}
