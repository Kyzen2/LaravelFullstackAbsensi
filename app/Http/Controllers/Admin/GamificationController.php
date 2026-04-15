<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointRule;
use App\Models\FlexibilityItem;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    public function index()
    {
        $rules = PointRule::all();
        $items = FlexibilityItem::all();
        
        return view('admin.gamification.index', compact('rules', 'items'));
    }

    public function storeRule(Request $request)
    {
        $request->validate([
            'rule_name' => 'required|string',
            'target_role' => 'required|string',
            'condition_operator' => 'required|in:<,>,BETWEEN,=',
            'condition_value' => 'required|string',
            'point_modifier' => 'required|numeric',
        ]);

        PointRule::create($request->all());

        return back()->with('success', 'Aturan Poin berhasil ditambahkan!');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'description' => 'nullable|string',
            'point_cost' => 'required|numeric',
            'stock_limit' => 'nullable|numeric',
        ]);

        FlexibilityItem::create($request->all());

        return back()->with('success', 'Token Kelonggaran berhasil ditambahkan!');
    }

    public function destroyRule(PointRule $rule)
    {
        $rule->delete();
        return back()->with('success', 'Aturan Poin dihapus!');
    }
    
    public function destroyItem(FlexibilityItem $item)
    {
        $item->delete();
        return back()->with('success', 'Token Kelonggaran dihapus!');
    }
}
