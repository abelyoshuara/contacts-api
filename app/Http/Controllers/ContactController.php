<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactCollection;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new ContactCollection(Contact::all()))
            ->additional([
                'status' => 'success',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $picture->storeAs('public/pictures', $picture->hashName());
            $contact = Contact::create([
                ...$request->all(),
                'picture' => $picture->hashName()
            ]);
        } else {
            $contact = Contact::create($request->all());
        }

        return (new ContactCollection([$contact]))
            ->additional([
                'status' => 'success',
                'message' => 'data berhasil disimpan'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return (new ContactCollection([$contact]))
            ->additional([
                'status' => 'success',
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $picture->storeAs('public/pictures', $picture->hashName());
            $contact->update([
                ...$request->all(),
                'picture' => $picture->hashName()
            ]);
        } else {
            $contact->update($request->all());
        }

        return (new ContactCollection([$contact]))
            ->additional([
                'status' => 'success',
                'message' => 'data berhasil diubah',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return (new ContactCollection([]))
            ->additional([
                'status' => 'success',
                'message' => 'data berhasil dihapus',
            ]);
    }
}
