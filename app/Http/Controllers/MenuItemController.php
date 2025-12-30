<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use Exception;

class MenuItemController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'label_en' => ['required', 'string', 'max:255'],
            'label_es' => ['nullable', 'string', 'max:255'],

            'url' => ['required', 'string', 'max:255'],

            'order' => ['nullable', 'integer', 'min:0'],

            'is_active' => ['nullable', 'boolean'],
            'open_in_new_tab' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of menu items.
     */
    public function index()
    {
        $menuItems = MenuItem::ordered()->get();

        return view('admin.menu_items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        return view('admin.menu_items.form');
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $menuItem = MenuItem::create($data);

            SystemLogger::log(
                'Menu item created',
                'info',
                'menu_items.store',
                [
                    'menu_item_id' => $menuItem->id,
                    'label_en' => $menuItem->label_en,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('menu-items.index')
                ->with('success', 'Menu item created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Menu item creation failed',
                'error',
                'menu_items.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create menu item.');
        }
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu_items.form', compact('menuItem'));
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $menuItem->update($data);

            SystemLogger::log(
                'Menu item updated',
                'info',
                'menu_items.update',
                [
                    'menu_item_id' => $menuItem->id,
                    'label_en' => $menuItem->label_en,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('menu-items.index')
                ->with('success', 'Menu item updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Menu item update failed',
                'error',
                'menu_items.update',
                [
                    'menu_item_id' => $menuItem->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update menu item.');
        }
    }

    /**
     * Remove the specified menu item.
     */
    public function destroy(MenuItem $menuItem)
    {
        try {
            $menuItem->delete();

            SystemLogger::log(
                'Menu item deleted',
                'warning',
                'menu_items.delete',
                [
                    'menu_item_id' => $menuItem->id,
                    'label_en' => $menuItem->label_en,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('menu-items.index')
                ->with('success', 'Menu item deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Menu item deletion failed',
                'error',
                'menu_items.delete',
                [
                    'menu_item_id' => $menuItem->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete menu item.');
        }
    }
}
