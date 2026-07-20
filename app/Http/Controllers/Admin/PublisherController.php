<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePublisherRequest;
use App\Http\Requests\Admin\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function index(Request $request): View
    {
        $publishers = Publisher::withCount('books')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.publishers.index', compact('publishers'));
    }

    public function create(): View
    {
        return view('admin.publishers.create');
    }

    public function store(StorePublisherRequest $request): RedirectResponse
    {
        Publisher::create($request->validated());

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher created successfully.');
    }

    public function edit(Publisher $publisher): View
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher): RedirectResponse
    {
        $publisher->update($request->validated());

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher): RedirectResponse
    {
        if (method_exists($publisher, 'books') && $publisher->books()->exists()) {
            return redirect()->route('admin.publishers.index')
                ->with('error', 'Cannot delete publisher because they have books assigned to them.');
        }

        $publisher->delete();

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher deleted successfully.');
    }
}
