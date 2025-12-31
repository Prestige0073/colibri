<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(20);
        $unreadCount = Contact::unread()->count();

        return view('admin.contacts', compact('contacts', 'unreadCount'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        // Marquer comme lu automatiquement quand on ouvre
        if (!$contact->is_read) {
            $contact->markAsRead();
        }

        return view('admin.contacts-show', compact('contact'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Marquer un message comme lu/non lu
     */
    public function toggleRead($id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact->is_read) {
            $contact->update([
                'is_read' => false,
                'read_at' => null,
            ]);
            $message = 'Message marqué comme non lu.';
        } else {
            $contact->markAsRead();
            $message = 'Message marqué comme lu.';
        }

        return redirect()->back()->with('success', $message);
    }
}
