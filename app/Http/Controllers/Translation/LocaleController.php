<?php

namespace App\Http\Controllers\Translation;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Get a list of locales.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $locales = Locale::all();
        if ($locales->isEmpty()) {
            abort(404, 'Translations not found.');
        }
        return response()->json(['message' => 'List of locales.', 'data' => $locales]);
    }

    /**
     * Store a newly created locale in storage.
     *
     * Validates the incoming request and creates a locale resource
     * with the specified code, name, and direction.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:locales,code',
            'name' => 'required|string',
            'direction' => 'required|string',
        ]);

        $locale = Locale::create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'direction' => $validated['direction'],
        ]);

        return response()->json([
            'message' => 'Locale saved successfully.',
            'data' => $locale,
        ]);
    }

    /**
     * Display the specified locale.
     *
     * Returns a JSON response with a message and the
     * locale resource.
     *
     * @param \App\Models\Locale $locale
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Locale $locale): JsonResponse
    {
        return response()->json([
            'message' => 'Show locale.',
            'data' => $locale,
        ]);
    }

    /**
     * Update the specified locale in storage.
     *
     * Validates the incoming request and updates the locale resource
     * with the specified code, name, and direction.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Locale $locale
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Locale $locale): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:locales,code,' . $locale->getKey(),
            'name' => 'required|string',
            'direction' => 'required|string',
        ]);

        $locale->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'direction' => $validated['direction'],
        ]);

        return response()->json([
            'message' => 'Locale updated successfully.',
            'data' => $locale,
        ]);
    }
    
    /**
     * Remove the specified locale from storage.
     *
     * @param \App\Models\Locale $locale
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Locale $locale): JsonResponse
    {
        $locale->delete();

        return response()->json([
            'message' => 'Locale deleted successfully.'
        ]);
    }
}
