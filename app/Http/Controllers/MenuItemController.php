<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json($request->user()->menuItems()->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Appetizer,Main Course,Dessert,Beverage'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'in:available,low,out'],
            'emoji' => ['nullable', 'string'],
        ]);

        $item = $request->user()->menuItems()->create($validated);

        return response()->json($item, 201);
    }

    public function update(Request $request, MenuItem $menuItem): JsonResponse
    {
        abort_unless($menuItem->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Appetizer,Main Course,Dessert,Beverage'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'in:available,low,out'],
            'favorite' => ['sometimes', 'boolean'],
            'emoji' => ['nullable', 'string'],
        ]);

        $menuItem->update($validated);

        return response()->json($menuItem);
    }

    public function destroy(Request $request, MenuItem $menuItem): JsonResponse
    {
        abort_unless($menuItem->user_id === $request->user()->id, 404);
        $menuItem->delete();

        return response()->json(['message' => 'Dish removed.']);
    }
}
