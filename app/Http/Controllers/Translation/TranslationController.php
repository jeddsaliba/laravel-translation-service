<?php

namespace App\Http\Controllers\Translation;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Returns a list of translations for the given locale code, grouped by tag.
     *
     * If a translation has tags, the key will be in the format `tag.key`, otherwise
     * it will just be `key`.
     *
     * @param string $localeCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, string $localeCode): JsonResponse
    {
        $locale = Locale::where('code', $localeCode)->firstOrFail();

        $translations = \App\Models\Translation::with('tags')
            ->where(['locale_id' => $locale->getKey()])
            ->when($request->key, function ($query) use ($request) {
                $query->where('key', $request->key);
            })
            ->when($request->tags, function ($query) use ($request) {
                $tags = explode(',', $request->tags);
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('tags.name', $tags);
                });
            })
            ->get();

        $result = [];

        $translations->each(function ($translation) use (&$result, $request) {
            $tag = $translation->tags()->when($request->tags, function (Builder $query) use ($request) {
                $tags = explode(',', $request->tags);
                $query->whereIn('tags.name', $tags);
            })->get();
            if ($tag->isNotEmpty()) {
                $tag->each(function ($tag) use (&$result, $translation) {
                    $result["{$tag->name}.{$translation->key}"] = $translation->value;
                });
            } else {
                $result[$translation->key] = $translation->value;
            }
        });

        if (empty($result)) {
            abort(404, 'Translations not found.');
        }
        return response()->json($result);
    }

    /**
     * Store a newly created translation in storage.
     *
     * Validates the incoming request and creates a translation resource
     * with the specified key, locale, and value. If tags are provided,
     * associates them with the translation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'locale' => 'required|string|exists:locales,code',
            'tags' => 'nullable|array',
            'tags.*' => 'string|exists:tags,name',
            'value' => 'required|string',
        ]);

        $locale = Locale::where('code', $validated['locale'])->firstOrFail();

        $translation = Translation::create([
            'key' => $validated['key'],
            'locale_id' => $locale->getKey(),
            'value' => $validated['value'],
        ]);

        if (!empty($validated['tags'])) {
            $tagIds = collect($validated['tags'])->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->getKey();
            });
            $translation->tags()->sync($tagIds);
        }

        return response()->json([
            'message' => 'Translation saved successfully.',
            'data' => $translation->load('tags', 'locale'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * Returns a JSON response with a message and a
     * Translation resource with its tags and locale
     * loaded.
     *
     * @param \App\Models\Translation $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Translation $translation): JsonResponse
    {
        return response()->json([
            'message' => 'Show translation.',
            'data' => $translation->load('tags', 'locale'),
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * Returns a JSON response with a message and a
     * Translation resource with its tags and locale
     * loaded.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Translation $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Translation $translation): JsonResponse
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'locale' => 'required|string|exists:locales,code',
            'tags' => 'nullable|array',
            'tags.*' => 'string|exists:tags,name',
            'value' => 'required|string',
        ]);
        
        $locale = Locale::where('code', $validated['locale'])->firstOrFail();

        $translation->update([
            'key' => $validated['key'],
            'locale_id' => $locale->getKey(),
            'value' => $validated['value'],
        ]);

        if (array_key_exists('tags', $validated)) {
            if (!empty($validated['tags'])) {
                $tagIds = collect($validated['tags'])->map(function ($tagName) {
                    return \App\Models\Tag::firstOrCreate(['name' => $tagName])->getKey();
                });
                $translation->tags()->sync($tagIds);
            } else {
                $translation->tags()->detach();
            }
        }
        return response()->json([
            'message' => 'Translation updated successfully.',
            'data'    => $translation->load('tags', 'locale'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * Removes the translation's tags relation before deleting the translation.
     *
     * @param \App\Models\Translation $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Translation $translation): JsonResponse
    {
        $translation->tags()->detach();

        $translation->delete();

        return response()->json([
            'message' => 'Translation deleted successfully.'
        ]);
    }
}
