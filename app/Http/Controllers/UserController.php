<?php
namespace App\Http\Controllers;

use App\Models\User as UserModel;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserModel::with('member')->get;
        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname'    => 'required|string|max:100',
            'lastname'     => 'required|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
            'role'         => 'required',
        ]);

        UserModel::create([
            'firstname'    => $validated['firstname'],
            'lastname'     => $validated['lastname'],
            'phone_number' => $validated['phone_number'] ?? null,
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'role'         => $validated['role'],
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'User added successfully!');
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'firstname'    => 'required|string|max:255',
            'lastname'     => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password'     => 'required|min:6|confirmed',
            'role'         => 'required|in:admin,staff,member,priest',
        ]);

        UserModel::create([
            'firstname'    => $request->firstname,
            'lastname'     => $request->lastname,
            'email'        => $request->email,
            'phone_number' => $request->phone_number, // store phone number
            'password'     => bcrypt($request->password),
            'role'         => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        return view('admin.update.update_user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);

        // Base validation for all users
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'role'      => 'required|in:admin,staff,member,priest',
            'password'  => 'nullable|string|min:6',
        ]);

        $user->firstname = $validated['firstname'];
        $user->lastname  = $validated['lastname'];
        $user->email     = $validated['email'];
        $user->role      = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();


        if ($user->role === 'member') {
            $memberValidated = $request->validate([
                'middle_name'    => 'nullable|string|max:255',
                'birth_date'     => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'address'        => 'nullable|string|max:255',
                'contact_number' => 'nullable|string|max:20',
            ]);

            // Create member record if it doesn't exist
            if (!$user->member) {
                $user->member()->create($memberValidated);
            } else {
                $user->member->update($memberValidated);
            }
        }

        return redirect()
            ->route('admin.users', ['id' => $id])
            ->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully. You can login now!');
    }
}
