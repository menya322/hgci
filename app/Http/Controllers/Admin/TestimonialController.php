<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::query()->ordered()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.create', [
            'testimonial' => new Testimonial(['is_published' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['photo'] = $this->storeImage($request, 'photo', 'testimonials');

        $testimonial = Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.edit', $testimonial)
            ->with('status', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', [
            'testimonial' => $testimonial,
        ]);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['photo'] = $this->storeImage($request, 'photo', 'testimonials', $testimonial->photo);

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.edit', $testimonial)
            ->with('status', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonial moved to the trash.');
    }
}
