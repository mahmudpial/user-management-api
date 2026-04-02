<?php
// app/Http/Controllers/Api/ContactController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Public — anyone can send a message
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully!',
            'data' => $contact
        ], 201);
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
            'data' => $query->paginate(20)
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