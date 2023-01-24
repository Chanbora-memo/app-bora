<?php

namespace App\Http\Controllers;


use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter
            (request(['tag', 'search']))->paginate(2)
            // use simplePaginate(numPages) to show "prev" and "next"
            // instead of col of pages
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show create form
    public function create() {
        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request) {
        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => ['required', Rule::unique('listings', 
                'company')], 
                //unique(NameOfTable, NameOfField)
                'email' => ['required', 'email'],
                'tags' => 'required',
                'description' => 'required',
                'location' => 'required',
                'website' => ['required', 'url']
            ]
        );

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos',
            'public');
        }

        $formFields['user_id'] = auth()->id();

        // Insert into DB
        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created
         successfully!');
    }

    // Show Edit Form
    public function edit(Listing $listing) {

        return view("listings.edit", ["listing" => $listing]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing) {

        // Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action!');
        }

        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'description' => 'required',
                'location' => 'required',
                'website' => ['required', 'url']
            ]
        );

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos',
            'public');
        }
        // Update into DB
        $listing->update($formFields);

        return back()->with('message', 'Listing updated
         successfully!');
    }

    // Delete Listings Data
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action!');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    // Manage Listings Data
    public function manage() {
        // dd(auth()->user()->listings());
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
