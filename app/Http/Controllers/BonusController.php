<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Buruh;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index()
    {
        $bonus = Bonus::with('buruh')->get();
        return view('bonus.index', compact('bonus'));
    }

    public function show($id)
    {
        $bonus = Bonus::with('buruh')->find($id);
        return view('bonus.show', compact('bonus'));
    }

    public function create()
    {
        return view('bonus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'buruh.*.name' => 'required|string|max:255',
            'buruh.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        $bonus = Bonus::create(['total_amount' => $request->total_amount]);

        foreach ($request->buruh as $buruhData) {
            $amount = ($request->total_amount * $buruhData['percentage']) / 100;
            $bonus->buruh()->create([
                'name' => $buruhData['name'],
                'percentage' => $buruhData['percentage'],
                'amount' => $amount
            ]);
        }

        return redirect()->route('bonus_list')->with('success', 'Berhasil simpan');
    }

    public function edit($id)
    {
        $bonus = Bonus::with('buruh')->find($id);
        return view('bonus.edit', compact('bonus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'buruh.*.name' => 'required|string|max:255',
            'buruh.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        $bonus = Bonus::findOrFail($id);
        $bonus->update(['total_amount' => $request->total_amount]);

        $existingBuruhIds = collect($request->buruh)->pluck('id')->filter()->toArray();
        $bonus->buruh()->whereNotIn('id', $existingBuruhIds)->delete();

        foreach ($request->buruh as $buruhData) {
            $amount = ($request->total_amount * $buruhData['percentage']) / 100;
            if (!empty($buruhData['id'])) {
                Buruh::where('id', $buruhData['id'])->update([
                    'name' => $buruhData['name'],
                    'percentage' => $buruhData['percentage'],
                    'amount' => $amount,
                ]);
            } else {
                $bonus->buruh()->create([
                    'name' => $buruhData['name'],
                    'percentage' => $buruhData['percentage'],
                    'amount' => $amount,
                ]);
            }
        }

        return redirect()->route('bonus_list')->with('success', 'Berhasil update');
    }

    public function destroy($id)
    {
        $bonus = Bonus::with('buruh')->find($id);
        $bonus->delete();
        return redirect()->route('bonus_list')->with('success', 'Berhasil hapus');
    }
}
