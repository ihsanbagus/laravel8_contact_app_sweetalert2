<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $contacts = Contact::where('name', 'like', '%' . $request->search . '%')->orderBy('name')->paginate(10);
        } else {
            $contacts = Contact::orderBy('name')->paginate(10);
        }
        return view('contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'address' => 'required',
            'phone' => 'required|numeric|digits_between:10,15',
            'avatar' => 'required|mimes:jpg,bmp,png',
        ]);

        $contact = new Contact;
        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            $request->avatar->storePublicly('public/img');
            if ($request->avatar->isValid()) {
                $contact->avatar = $request->avatar->hashName();
                $contact->save();
            }
        }
        return redirect()->route('contact.index')->with('pesan', 'Success Deleted!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required|max:30',
            'address' => 'required',
            'phone' => 'required|numeric|digits_between:10,15',
        ]);

        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            $request->avatar->storePublicly('public/img');
            if ($request->avatar->isValid()) {
                $contact->avatar = $request->avatar->hashName();
            }
        }
        $contact->save();
        return redirect()->route('contact.index')->with('pesan', 'Success Deleted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if ($contact->avatar != 'avatar.png') {
            Storage::delete('public/img/' . $contact->avatar);
        }
        $contact->delete();
        return redirect()->route('contact.index')->with('pesan', 'Success Deleted!');
    }
}
