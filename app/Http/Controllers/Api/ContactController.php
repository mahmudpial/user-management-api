<?php

// app/Http/Controllers/Api/ContactController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReceived;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    // Public — anyone can send a message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        $contact = Contact::create($validated);

        try {
            Mail::to(config('mail.contact_to'))->queue(new ContactMessageReceived($contact));
        } catch (Throwable $exception) {
            Log::error('Unable to queue portfolio contact email.', [
                'contact_id' => $contact->id,
                'exception' => $exception,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'We could not send your message right now. Please try again later.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
        ]);
    }

    // Admin — list all messages
    public function index(Request $request)
    {
        $query = Contact::latest();

        if ($request->filled('unread')) {
            $query->where('is_read', false);
        }

        return response()->json([
            'status' => true,
            'data' => $query->paginate(20),
        ]);
    }

    // Admin — mark as read
    public function markRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);

        return response()->json(['status' => true, 'message' => 'Marked as read.']);
    }

    // Admin — delete message
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json(['status' => true, 'message' => 'Message deleted.']);
    }
}
